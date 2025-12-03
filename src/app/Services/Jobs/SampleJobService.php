<?php

namespace App\Services\Jobs;

use Illuminate\Support\Facades\Log;

use App\Services\PushNotification\SenderService;

use App\Models\User;

class SampleJobService
{
    private User $user;

    public function __construct(
        private SenderService $senderService,
    ) {}

    /**
     * サンプルジョブ実行
     */
    public function exec($time, User $user): void
    {
        $this->user = $user;

        Log::info('SampleJob: Begin!!! ' . $time . ' ' . $this->user->name);

        $this->checkPoint('遅いジョブを開始しました', 'bigin');

        for ($i = 0; $i < 10; $i++) {
            sleep(1);

            Log::info('SampleJob: Progress ' . $i);

            $this->checkPoint('遅いジョブの経過:', 'progress', [
                'cursor' => $i + 1,
                'total' => 10,
            ]);
        }

        $this->checkPoint('遅いジョブが完了しました', 'end');

        Log::info('SampleJob: End!!! ' . $time . ' ' . $this->user->name);
    }

    /**
     * チェックポイント送信
     */
    public function checkPoint($message, string $detailType, array $detail = []): void
    {
        $detail['detailType'] = $detailType;

        $options = [
            'type' => 'sample_job_progress',
            'message' => true,
            'detail' => $detail,
        ];
        if ($detailType === 'end') {
            $options['notice'] = true;
        }
        $result = $this->senderService->sendByUser(
            $message,
            $this->user,
            $options
        );
    }
}
