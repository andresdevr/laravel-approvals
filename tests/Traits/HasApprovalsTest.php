<?php

namespace Andresdevr\LaravelApprovals\Tests\Traits;

use Andresdevr\LaravelApprovals\Tests\Models\TestModel;
use Andresdevr\LaravelApprovals\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HasApprovalsTest extends TestCase
{
    //use RefreshDatabase;
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


    /**
     * @test
     */
    public function trait_can_save_pending_changes_into_model_column()
    {
        $model = $this->createModel();

        $change = 'test2';

        $model->name = $change;


        $model->addToPending();

        $this->assertDatabaseHas('test_models', [
            'id' => 1,
            'name' => 'test1',
            'value' => 1,
            'pending_changes' => '{"name":{"user_id":null,"change":"' . $change .'","reason_for_denial":"","approved":0}}'
        ]);
    }

    /**
     * @test
     */
    public function trait_respect_none_strict_comparison()
    {
        $model = $this->createModel();

        $change = true;
        $change2 = "test32";

        $model->value = $change;
        $model->name = $change2;

        $model->notStrict()->addToPending();

        $this->assertDatabaseHas('test_models', [
            'id' => "1",
            'name' => 'test1',
            'value' => "1",
            'pending_changes' => '{"name":{"user_id":null,"change":"' . $change2 .'","reason_for_denial":"","approved":0}}'
        ]);
    }

    private function createModel($name = "test1", $value = 1) : TestModel
    {
        $model = TestModel::create([
            'name' => $name,
            'value' => $value
        ]);

        return TestModel::first();
    }
}
