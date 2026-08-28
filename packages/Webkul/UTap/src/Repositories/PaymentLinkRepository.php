<?php

namespace Webkul\UTap\Repositories;

use Illuminate\Support\Str;
use Webkul\Core\Eloquent\Repository;
use Webkul\UTap\Contracts\PaymentLink;

class PaymentLinkRepository extends Repository
{
    public function model(): string
    {
        return PaymentLink::class;
    }

    public function createPaymentLink(array $data): PaymentLink
    {
        $code = 'pl_'.strtolower(Str::random(12));

        $data['link_code'] = $code;
        $data['currency'] = $data['currency'] ?? 'AED';
        $data['status'] = $data['status'] ?? \Webkul\UTap\Models\PaymentLink::STATUS_PENDING;

        if (! empty($data['validity_days'])) {
            $data['expires_at'] = now()->addDays((int) $data['validity_days']);
        }

        return $this->create($data);
    }

    public function findByCode(string $code): ?PaymentLink
    {
        return $this->findOneWhere(['link_code' => $code]);
    }
}
