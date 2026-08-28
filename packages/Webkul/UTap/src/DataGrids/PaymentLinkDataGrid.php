<?php

namespace Webkul\UTap\DataGrids;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class PaymentLinkDataGrid extends DataGrid
{
    public function prepareQueryBuilder(): Builder
    {
        $queryBuilder = DB::table('payment_links')
            ->select(
                'payment_links.id as id',
                'payment_links.link_code as link_code',
                'payment_links.name as name',
                'payment_links.email as email',
                'payment_links.phone as phone',
                'payment_links.amount as amount',
                'payment_links.currency as currency',
                'payment_links.reason as reason',
                'payment_links.type as type',
                'payment_links.status as status',
                'payment_links.utap_txn_id as utap_txn_id',
                'payment_links.paid_at as paid_at',
                'payment_links.created_at as created_at'
            );

        $this->addFilter('id', 'payment_links.id');
        $this->addFilter('link_code', 'payment_links.link_code');
        $this->addFilter('name', 'payment_links.name');
        $this->addFilter('email', 'payment_links.email');
        $this->addFilter('phone', 'payment_links.phone');
        $this->addFilter('amount', 'payment_links.amount');
        $this->addFilter('status', 'payment_links.status');
        $this->addFilter('type', 'payment_links.type');
        $this->addFilter('created_at', 'payment_links.created_at');

        return $queryBuilder;
    }

    public function prepareColumns(): void
    {
        $this->addColumn([
            'index' => 'id',
            'label' => 'ID',
            'type' => 'integer',
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'link_code',
            'label' => 'Code',
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'closure' => function ($row) {
                return '<span class="font-mono text-xs font-bold text-pink-600">#'.strtoupper($row->link_code).'</span>';
            },
        ]);

        $this->addColumn([
            'index' => 'name',
            'label' => 'Customer Name',
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'email',
            'label' => 'Email',
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'amount',
            'label' => 'Amount',
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'closure' => function ($row) {
                return '<span class="font-bold text-gray-900 dark:text-white">AED '.number_format((float) $row->amount, 2).'</span>';
            },
        ]);

        $this->addColumn([
            'index' => 'reason',
            'label' => 'Reason for Payment',
            'type' => 'string',
            'searchable' => true,
            'closure' => function ($row) {
                return '<span class="max-w-[200px] truncate block" title="'.e($row->reason).'">'.e($row->reason).'</span>';
            },
        ]);

        $this->addColumn([
            'index' => 'type',
            'label' => 'Type',
            'type' => 'string',
            'sortable' => true,
            'closure' => function ($row) {
                if ($row->type === 'public_qr') {
                    return '<span class="badge badge-sm badge-info">📱 Public QR</span>';
                }

                return '<span class="badge badge-sm badge-primary">🔗 Admin Link</span>';
            },
        ]);

        $this->addColumn([
            'index' => 'status',
            'label' => 'Status',
            'type' => 'string',
            'sortable' => true,
            'filterable' => true,
            'closure' => function ($row) {
                if ($row->status === 'completed') {
                    return '<span class="badge badge-sm badge-success">✓ Completed</span>';
                } elseif ($row->status === 'expired') {
                    return '<span class="badge badge-sm badge-danger">Expired</span>';
                }

                return '<span class="badge badge-sm badge-warning">⏳ Pending</span>';
            },
        ]);

        $this->addColumn([
            'index' => 'created_at',
            'label' => 'Created Date',
            'type' => 'datetime',
            'sortable' => true,
            'filterable' => true,
        ]);
    }

    public function prepareActions(): void
    {
        $this->addAction([
            'icon' => 'icon-view',
            'title' => 'View Details & QR',
            'method' => 'GET',
            'url' => function ($row) {
                return route('admin.sales.payment_links.view', $row->id);
            },
        ]);
    }
}
