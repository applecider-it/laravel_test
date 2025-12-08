<?php

namespace App\Services\Development;

use Illuminate\Support\Facades\Log;

use App\Jobs\SampleJob;

/**
 * 開発用フロントエンド管理
 */
class FrontendService{
    /**
     * スロージョブ開始
     */
    public function startSlowJob()
    {
        $user = auth()->user();
        $all = request()->all();
        Log::info('startSlowJob', [$user->name, $all]);
        SampleJob::dispatch(date('H:i:s'), $user);

        return [
            'status' => true,
        ];
    }
}