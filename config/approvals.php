<?php

use Andresdevr\LaravelApprovals\Events\ModelRequestChanges;
use Andresdevr\LaravelApprovals\Events\ModelWasApproved;
use Andresdevr\LaravelApprovals\Events\ModelWasDenied;
use Andresdevr\LaravelApprovals\Models\PendingChange;

return [

     /*
    |--------------------------------------------------------------------------
    | Default key
    |--------------------------------------------------------------------------
    |
    | This option controls the variable to use in cache and model,
    | does't work with the database mode option, in cache use
    */
    'key' => env('APPROVALS_KEY', 'pending_changes'),

    'mode' => env('APPROVALS_MODE', 'model'),

    'cache_tag' => env('APPROVALS_CACHE_TAG', 'approvals'),

    'timestamps' => env('APPROVALS_USE_TIMESTAMP'),

    'strict' => env('APPROVALS_STRICT', true),

    'use_reason_for_denial' => env('APPROVALS_USE_REASON_FOR_DENIAL', true),

    'use_user' => env('APPROVALS_USE_USER', true),

    'table_name' => env('APPROVALS_TABLE_NAME', 'pending_changes'),

    'model' => PendingChange::class,

    'status' => [
        'approved' => env('APPROVALS_APPROVED_STATUS', 1),

        'pending' => env('APPROVALS_PENDING_STATUS', 0),

        'denied' => env('APPROVALS_DENIED_STATUS', -1)
    ],

    'events' => [
        'model_request_changes' => ModelRequestChanges::class,
        'model_was_approved' => ModelWasApproved::class,
        'model_was_denied' => ModelWasDenied::class   
    ]
];