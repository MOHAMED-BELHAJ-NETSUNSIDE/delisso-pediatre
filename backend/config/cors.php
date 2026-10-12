<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    // Le navigateur de l'application réutilise cette réponse OPTIONS pendant 24 h.
    'max_age' => 86400,

    'supports_credentials' => false,

];
