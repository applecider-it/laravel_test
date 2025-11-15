<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Jobs\TestJob;
use App\Models\User;

class TestJobRunner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-job-runner';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::first();
        TestJob::dispatch(date('H:i:s'), $user);
    }
}
