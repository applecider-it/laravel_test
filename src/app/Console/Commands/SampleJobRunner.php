<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Jobs\SampleJob;
use App\Models\User;

class SampleJobRunner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sample-job-runner';

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
        SampleJob::dispatch(date('H:i:s'), $user);
    }
}
