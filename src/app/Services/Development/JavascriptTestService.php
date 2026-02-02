<?php

namespace App\Services\Development;

use Illuminate\Support\Facades\Log;

use App\Jobs\SampleJob;

use App\Models\User;

/**
 * 開発者向けページのJavascriptテスト管理
 */
class JavascriptTestService{
    /**
     * スロージョブ開始
     */
    public function startSlowJob(User $user, int $test, $test2)
    {
        Log::info('startSlowJob', [$user->name, $test, $test2]);

        SampleJob::dispatch(date('H:i:s'), $user);

        return [
            'status' => true,
        ];
    }

    /**
     * テストチャンネルにメッセージ送信
     */
    public function sendTestChannel($message, int $id)
    {
        Log::info('sendTestChannel', [$message, $id]);

        event(new \App\Events\MessageSent($message, $id));

        return [
            'status' => true,
        ];
    }
}