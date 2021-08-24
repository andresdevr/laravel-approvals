<?php

namespace Andresdevr\LaravelApprovals\Models;

use Illuminate\Database\Eloquent\Model;

class PendingChange extends Model
{
	protected $guarded = [
        'id'
    ];

    /**
     * Get the parent pendingChangeable model (...).
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function pendingChangeable()
    {
        return $this->morphTo();
    }
}