<?php

namespace Webkul\UTap\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\UTap\Contracts\PaymentLink as PaymentLinkContract;

class PaymentLink extends Model implements PaymentLinkContract
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_EXPIRED = 'expired';

    public const STATUS_FAILED = 'failed';

    public const TYPE_ADMIN_CREATED = 'admin_created';

    public const TYPE_PUBLIC_QR = 'public_qr';

    protected $table = 'payment_links';

    protected $fillable = [
        'link_code',
        'name',
        'email',
        'phone',
        'amount',
        'currency',
        'reason',
        'type',
        'status',
        'utap_invoice_id',
        'utap_txn_id',
        'utap_ipg_id',
        'utap_payment_link',
        'paid_at',
        'expires_at',
        'metadata',
    ];

    protected $casts = [
        'amount' => 'decimal:4',
        'paid_at' => 'datetime',
        'expires_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function isPaid(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isExpired(): bool
    {
        if ($this->isPaid()) {
            return false;
        }

        return $this->expires_at && $this->expires_at->isPast();
    }

    public function getUrl(): string
    {
        return route('payment_link.checkout', ['linkCode' => $this->link_code]);
    }
}
