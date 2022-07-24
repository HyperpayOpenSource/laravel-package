<?php

return [

    "environment" => "test",

    "endpoints"=> [
        'live' => [
            'paymentWidgets' => 'https://eu-prod.oppwa.com/v1/paymentWidgets.js?checkoutId=',
            'checkouts' => 'https://eu-prod.oppwa.com/v1/checkouts',
        ],
        'test' => [
            'paymentWidgets' => 'https://eu-test.oppwa.com/v1/paymentWidgets.js?checkoutId=',
            'checkouts' => 'https://eu-test.oppwa.com/v1/checkouts',
        ],
    ],

    "gatewayes" => [
        "card" => [
            "enabled" => false,
            'entity_id' => "",
            "access_token" => "",
            "currency" => "SAR",
            "transaction_type" => "DB",
            "brands" => "VISA MASTER AMEX",
            "label" => "Cridet Card",
        ],

        "mada" => [
            "enabled" => false,
            'entity_id' => "",
            "access_token" => "",
            "currency" => "SAR",
            "transaction_type" => "DB",
            "brands" => "MADA",
            "label" => "Mada Debit Card",
        ],
    ]
];
