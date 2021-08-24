<?php

namespace Andresdevr\LaravelApprovals\Traits;

/**
 * 
 */
trait HasPendingChanges
{
    /**
     * relatinoship with pending changes
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
	public function pendingChanges()
    {
        return $this->morphMany(config('approvals.model'), 'pendingable');
    }
}
