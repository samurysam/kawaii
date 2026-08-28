<?php

namespace Webkul\UTap\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\UTap\DataGrids\QRPaymentDataGrid;
use Webkul\UTap\Mail\PaymentLinkReceiptMail;
use Webkul\UTap\Models\PaymentLink;
use Webkul\UTap\Repositories\PaymentLinkRepository;

class QRPaymentController extends Controller
{
    public function __construct(
        protected PaymentLinkRepository $paymentLinkRepository
    ) {}

    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            return datagrid(QRPaymentDataGrid::class)->process();
        }

        $publicPayUrl = route('payment_link.open_pay');
        $publicQrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=600x600&data='.urlencode($publicPayUrl);

        return view('utap::admin.qr-payments.index', compact('publicPayUrl', 'publicQrCodeUrl'));
    }

    public function view(int $id): View|JsonResponse
    {
        $paymentLink = $this->paymentLinkRepository->findOrFail($id);
        $url = route('payment_link.checkout', ['linkCode' => $paymentLink->link_code]);
        $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data='.urlencode($url);

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'data' => [
                    'id' => $paymentLink->id,
                    'link_code' => strtoupper($paymentLink->link_code),
                    'name' => $paymentLink->name,
                    'email' => $paymentLink->email,
                    'phone' => $paymentLink->phone ?: 'N/A',
                    'amount' => 'AED '.number_format((float) $paymentLink->amount, 2),
                    'reason' => $paymentLink->reason,
                    'type' => 'Public QR',
                    'status' => $paymentLink->status,
                    'utap_txn_id' => $paymentLink->utap_txn_id ?: 'N/A',
                    'paid_at' => $paymentLink->paid_at ? $paymentLink->paid_at->format('d M Y, h:i A') : 'Pending',
                    'created_at' => $paymentLink->created_at->format('d M Y, h:i A'),
                    'url' => $url,
                    'qr_code_url' => $qrCodeUrl,
                ],
            ]);
        }

        return view('utap::admin.qr-payments.view', compact('paymentLink', 'url', 'qrCodeUrl'));
    }

    public function resendReceipt(int $id): RedirectResponse
    {
        $paymentLink = $this->paymentLinkRepository->findOrFail($id);

        try {
            Mail::send(new PaymentLinkReceiptMail($paymentLink));
            session()->flash('success', 'Automated Kawaii payment receipt emailed to '.$paymentLink->email.'! 📧💖');
        } catch (\Throwable $e) {
            Log::error('Failed to resend QR Payment email receipt: '.$e->getMessage());
            session()->flash('error', 'Could not send email: '.$e->getMessage());
        }

        return redirect()->back();
    }

    public function markPaid(int $id): RedirectResponse
    {
        $paymentLink = $this->paymentLinkRepository->findOrFail($id);

        $this->paymentLinkRepository->update([
            'status' => PaymentLink::STATUS_COMPLETED,
            'paid_at' => now(),
            'utap_txn_id' => $paymentLink->utap_txn_id ?: 'MANUAL-POS-'.time(),
        ], $paymentLink->id);

        $freshPayment = $this->paymentLinkRepository->find($paymentLink->id);

        try {
            Mail::send(new PaymentLinkReceiptMail($freshPayment));
        } catch (\Throwable $e) {
            Log::error('Failed to send QR Payment email receipt on markPaid: '.$e->getMessage());
        }

        session()->flash('success', 'QR Payment marked as Completed and receipt email sent! 💖');

        return redirect()->back();
    }
}
