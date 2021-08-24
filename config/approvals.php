<?php

use Andresdevr\LaravelApprovals\Events\ModelRequestChanges;
use Andresdevr\LaravelApprovals\Events\ModelWasApproved;
use Andresdevr\LaravelApprovals\Events\ModelWasDenied;

return [
    'key' => env('APPROVALS_KEY', 'pending_changes'),

    'mode' => env('APPROVALS_MODE', 'database'),

    'cache_tag' => env('APPROVALS_CACHE_TAG', 'approvals'),

    'timestamps' => env('APPROVAL_USE_TIMESTAMP'),

    'strict' => env('APPROVALS_STRIC', true),

    'use_reason_for_denial' => env('APPROVALS_USE_REASON_FOR_DENIAL', true),

    'use_user' => env('APPROVALS_USE_USER', true),

    'status' => [
        'approved' => env('APPROVALS_APPROVED_STATUS', 1),

        'pending' => env('APPROVALS_PENDING_STATUS', 0),

        'denied' => env('APPROVALS_DENIED_STATUS', -1)
    ],

    'events' => [
        'model_request_chages' => ModelRequestChanges::class,
        'model_was_approved' => ModelWasApproved::class,
        'model_was_denied' => ModelWasDenied::class   
    ]
];