<?php

namespace Andresdevr\LaravelApprovals\Tests;

use Andresdevr\LaravelApprovals\ApprovalsServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as TestbenchTestCase;

class TestCase extends TestbenchTestCase
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getEnvironmentSetUp($app)
    {
        include_once __DIR__ . '/../database/migrations/create_pending_changes_table.php.stub';

        (new \CreatePendingChangesTable)->up();

        $this->migrateTestModel();
    }

    private function migrateTestModel()
    {
        Schema::create('test_models', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('value')->nullable();
            $table->timestamps();
        });
    }

    protected function getPackageProviders($app)
    {
        return [
		    ApprovalsServiceProvider::class
        ];
    }
}
