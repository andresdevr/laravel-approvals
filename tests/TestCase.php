<?php

namespace Andresdevr\LaravelApprovals\Tests;

use Andresdevr\LaravelApprovals\ApprovalsServiceProvider;
use Illuminate\Database\Eloquent\Model;
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
    }

    protected function getPackageProviders($app)
    {
        return [
		    ApprovalsServiceProvider::class
        ];
    }
}
