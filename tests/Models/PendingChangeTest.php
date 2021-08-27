<?php

namespace Andresdevr\LaravelApprovals\Tests\Models;

use Andresdevr\LaravelApprovals\Models\PendingChange;
use Andresdevr\LaravelApprovals\Tests\TestCase;
use Andresdevr\LaravelApprovals\Traits\HasApprovals;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PendingChangeTest extends TestCase
{
    /**
     * @test
     */
	public function model_has_polymorphic_relationship_function()
    {
        $t = new PendingChange();

        $this->assertInstanceOf(MorphTo::class, $t->pendingChangeable());
    }
}	
