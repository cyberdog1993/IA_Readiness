<?php

return [
    'analytics' => [
        'google' => env('GOOGLE_ANALYTICS_ID'),
        'plausible' => env('PLAUSIBLE_DOMAIN'),
    ],
    'meta' => [
        'pixel' => env('META_PIXEL_ID'),
    ],
    'linkedin' => [
        'insight_tag' => env('LINKEDIN_INSIGHT_TAG'),
    ],
    'automation' => [
        'lead_created_webhook' => env('LEAD_CREATED_WEBHOOK_URL'),
        'n8n_webhook' => env('N8N_WEBHOOK_URL'),
        'crm_webhook' => env('CRM_WEBHOOK_URL'),
        'internal_notify_webhook' => env('INTERNAL_NOTIFY_WEBHOOK_URL'),
    ],
    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],
    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
];
