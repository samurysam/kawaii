<?php

namespace Webkul\UTap\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\UTap\DataGrids\PaymentLinkDataGrid;
use Webkul\UTap\Models\PaymentLink;
use Webkul\UTap\Repositories\PaymentLinkRepository;

class PaymentLinkController extends Controller
{
    public function __construct(
        protected PaymentLinkRepository $paymentLinkRepository
    ) {}

    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            return datagrid(PaymentLinkDataGrid::class)->process();
        }

        return view('utap::admin.payment-links.index');
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'amount' => 'required|numeric|min:1|max:100000',
            'reason' => 'required|string|max:1000',
            'validity_days' => 'nullable|integer|min:1|max:365',
        ]);

        $paymentLink = $this->paymentLinkRepository->createPaymentLink([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'amount' => (float) $validated['amount'],
            'currency' => 'AED',
            'reason' => $validated['reason'],
            'type' => PaymentLink::TYPE_ADMIN_CREATED,
            'status' => PaymentLink::STATUS_PENDING,
            'validity_days' => $validated['validity_days'] ?? 30,
        ]);

        $url = route('payment_link.checkout', ['linkCode' => $paymentLink->link_code]);
        $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data='.urlencode($url);

        return response()->json([
            'message' => 'Payment link created successfully! 💖',
            'data' => [
                'id' => $paymentLink->id,
                'link_code' => $paymentLink->link_code,
                'url' => $url,
                'qr_code_url' => $qrCodeUrl,
                'amount' => $paymentLink->amount,
                'name' => $paymentLink->name,
                'email' => $paymentLink->email,
            ],
        ]);
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
                    'type' => $paymentLink->type === 'public_qr' ? 'Public QR' : 'Admin Link',
                    'status' => $paymentLink->status,
                    'utap_txn_id' => $paymentLink->utap_txn_id ?: 'N/A',
                    'paid_at' => $paymentLink->paid_at ? $paymentLink->paid_at->format('d M Y, h:i A') : 'Pending',
                    'created_at' => $paymentLink->created_at->format('d M Y, h:i A'),
                    'url' => $url,
                    'qr_code_url' => $qrCodeUrl,
                ],
            ]);
        }

        return view('utap::admin.payment-links.view', compact('paymentLink'));
    }
}
