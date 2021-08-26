<?php

namespace Andresdevr\LaravelApprovals\Tests;

use Andresdevr\LaravelApprovals\Traits\HasApprovals;
use Illuminate\Database\Eloquent\Model;

class HasApprovalsTest extends TestCase
{
    /**
     * @test
     */
    public function trait_has_default_approval_key()
    {  
        $model = new TestModel();

        $this->assertEquals(config('approvals.key'), $model->getApprovalKey());
    }

    /**
     * @test
     */
	public function trait_can_use_dynamical_approval_key()
    {
        $model = new TestModel();

        $key = 'testing_key';

        $model->setApprovalKey($key);

        $this->assertEquals($key, $model->getApprovalKey());
    }
}	



class TestModel extends Model
{
    use HasApprovals;
}