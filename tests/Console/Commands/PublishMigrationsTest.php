<?php

namespace Andresdevr\LaravelApprovals\Tests\Console\Commands;

use Andresdevr\LaravelApprovals\Tests\TestCase;
use Illuminate\Support\Facades\Artisan;

class PublishMigrationsTest extends TestCase
{
	/**
     * @test
     */
    public function the_command_publish_the_pending_changes_table_migration()
    {
        $this->artisan('approvals:migrations')
                ->expectsOutput('Migrations published');

        $this->assertTrue(true);
    }
}