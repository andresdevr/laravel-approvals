<?php

namespace Andresdevr\LaravelApprovals\Tests;

use Andresdevr\LaravelApprovals\ApprovalsServiceProvider;
use Orchestra\Testbench\TestCase as TestbenchTestCase;

class TestCase extends TestbenchTestCase
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getPackageProviders($app)
    {
        return [
		ApprovalsServiceProvider::class
        ];
    }
}
