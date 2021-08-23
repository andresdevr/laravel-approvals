<?php



return [
    'key' => env('APPROVALS_KEY', 'pending_changes'),

    'mode' => env('APPROVALS_MODE', 'database'),

    'strict' => env('APPROVALS_STRIC', true),

    'status' => [
        'approved' => env('APPROVALS_APPROVED_STATUS', 1),

        'pending' => env('APPROVALS_PENDING_STATUS', 0),

        'denied' => env('APPROVALS_DENIED_STATUS', -1)
    ]
];