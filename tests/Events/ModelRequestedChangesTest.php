<?php

namespace Andresdevr\LaravelApprovals\Tests\Events;

use Andresdevr\LaravelApprovals\Events\ModelRequestChanges;
use Andresdevr\LaravelApprovals\Tests\Models\TestModel;
use Andresdevr\LaravelApprovals\Tests\TestCase;
use Illuminate\Support\Facades\Event;

class ModelRequestedChangesTest extends TestCase
{
	/**
     * @test
     */
    public function model_request_changes_is_emitted_when_changes_are_requested_in_a_model()
    {
        Event::fake();

        TestModel::make()->addToPending();
       
        Event::assertDispatched(ModelRequestChanges::class);

    }

    /**
     * @test
     */
    public function model_request_changes_is_not_emitted_when_changes_are_requested_in_a_model()
    {
        Event::fake();

        TestModel::make()->addToPendingQuietly();

        Event::assertNotDispatched(ModelRequestChanges::class);
    }
}