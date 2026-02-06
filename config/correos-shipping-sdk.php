<?php

return [
    'oauth' => [
        'client_id' => env('CORREOS_OAUTH_CLIENT_ID'),
        'client_secret' => env('CORREOS_OAUTH_CLIENT_SECRET'),
        'token_url' => env('CORREOS_TOKEN_URL', 'https://apioauthcid.correos.es/Api/Authorize/Token'),
        'scope' => env('CORREOS_OAUTH_SCOPE', 'AP3 LBS RCG'),
    ],
    'gateway' => [
        'client_id' => env('CORREOS_GATEWAY_CLIENT_ID'),
        'client_secret' => env('CORREOS_GATEWAY_CLIENT_SECRET'),
    ],
    'base_urls' => [
        'preregister' => env('CORREOS_PREREGISTER_URL', 'https://api1.correos.es/admissions/preregister/api/v1'),
        'labels' => env('CORREOS_LABELS_URL', 'https://api1.correos.es/support/labels/api/v1'),
        'tracking' => env('CORREOS_TRACKING_URL', 'https://api1.correos.es/support/trackpub/api/v2'),
    ],
];
