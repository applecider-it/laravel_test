<?php

namespace App\Services\Jobs;

use Illuminate\Support\Facades\Log;

use App\Services\PushNotification\SenderService;
use App\Services\WebSocket\SystemService as WebSocketSystemService;
use App\Services\Channels\ProgressChannel;

use App\Models\User;

class SampleJobService
{
    private User $user;

    public function __construct(
        private SenderService $senderService,
        private WebSocketSystemService $webSocketSystemService,
    ) {}

    /**
     * サンプルジョブ実行
     */
    public function exec($time, User $user): void
    {
        $this->user = $user;

        Log::info('SampleJob: Begin!!! ' . $time . ' ' . $this->user->name);

        $this->checkPoint('遅いジョブを開始しました', 'bigin');

        $total = 100;

        for ($i = 0; $i < $total; $i++) {
            usleep(1000000 * 0.1);

            Log::info('SampleJob: Progress ' . $i);

            $this->checkPointWs('遅いジョブの経過:', 'progress', [
                'cursor' => $i + 1,
                'total' => $total,
            ]);
        }

        $this->checkPoint('遅いジョブが完了しました', 'end');

        Log::info('SampleJob: End!!! ' . $time . ' ' . $this->user->name);
    }

    /**
     * チェックポイント送信(WebSocket)
     */
    public function checkPointWs($message, string $detailType, array $detail = []): void
    {
        $detail['detailType'] = $detailType;

        $data = [
            "info" => [
                'type' => 'sample_job_progress',
                'title' => $message,
                'detail' => $detail,
            ],
        ];

        $response = $this->webSocketSystemService->publish(ProgressChannel::getChannel($this->user->id), $data);

        Log::info('websocket_test response', [$response]);
    }

    /**
     * チェックポイント送信(Push通知)
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
