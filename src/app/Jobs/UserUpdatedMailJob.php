<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use App\Mail\UserUpdatedMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

/**
 * ユーザー更新時メール用のジョブ
 */
class UserUpdatedMailJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private User $user)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->user->email)->send(new UserUpdatedMail($this->user));
    }
}
