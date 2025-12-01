<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

use App\Services\Jobs\SampleJobService;

use App\Models\User;

class SampleJob implements ShouldQueue
{
    use Queueable;

    private SampleJobService $sampleJobService;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private string $time,
        private User $user
    ) {
        $this->sampleJobService = app(SampleJobService::class);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->sampleJobService->exec($this->time, $this->user);
    }
}
