<?php

namespace Andresdevr\LaravelApprovals\Tests\Models;

use Andresdevr\LaravelApprovals\Traits\HasApprovals;
use Andresdevr\LaravelApprovals\Traits\HasPendingChanges;
use Illuminate\Database\Eloquent\Model;

/**
 * @codeCoverageIgnore
 */
class TestModel extends Model
{
    use HasApprovals;
    use HasPendingChanges;

    protected $fillable = [
        'name',
        'value'
    ];
}
