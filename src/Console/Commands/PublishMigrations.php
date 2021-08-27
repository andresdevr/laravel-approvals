<?php

namespace Andresdevr\LaravelApprovals\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class PublishMigrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'approvals:migrations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish the migrations into database/migrations folder of the project';
        
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
	    Artisan::call('vendor:publish', [
            "--provider" => "Andresdevr\LaravelApprovals\ApprovalsServiceProvider",
            "--tag" => "approvals-migrations"
        ]);

        $this->info("Migrations published");
    }
}
