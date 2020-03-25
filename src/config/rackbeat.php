<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 15.34
 */

return [

    'token'    => env( 'RACKBEAT_API_TOKEN' ),
    'user_agent' => env('RACKBEAT_USER_AGENT', 'kg-bot/laravel-rackbeat'),
    'supplier' => [

        'fields' => [

            'default' => [

                'payment_terms_id' => 1001,
            ],
        ],
    ],
    'base_uri' => env('RACKBEAT_BASE_URL', 'https://app.rackbeat.com/api/'),
    'api_limit' => env('RACKBEAT_API_LIMIT', 480), // Number of allowed requests per minute
];
