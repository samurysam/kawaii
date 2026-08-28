<?php

use Webkul\UTap\Payment\UTap;

return [
    'utap' => [
        'code' => 'utap',
        'title' => 'uTap by e&',
        'description' => 'Pay securely through uTap by e&.',
        'class' => UTap::class,
        'active' => false,
        'client_code' => '',
        'user_name' => '',
        'user_pwd' => '',
        'cust_code' => '',
        'cust_group_cust_code' => '',
        'ref_id' => '',
        'accepted_currencies' => 'AED',
        'link_validity' => 30,
        'sandbox' => true,
        'sort' => 10,
    ],
];
