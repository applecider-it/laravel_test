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
    public function exec($time, User $user)
    {
        $this->user = $user;

        Log::info('SampleJob: Begin!!! ' . $time . ' ' . $this->user->name);

        $this->checkPointPush('遅いジョブを開始しました', 'bigin', []);

        $total = 20;
        $waitSecond = 0.3;

        for ($i = 0; $i < $total; $i++) {
            usleep(1000000 * $waitSecond);

            Log::info('SampleJob: Progress ' . $i);

            $this->checkPointWs('遅いジョブの経過:', 'progress', [
                'cursor' => $i + 1,
                'total' => $total,
            ]);
        }

        $this->checkPointPush($this->user->name . 'さん。遅いジョブが完了しました', 'end', [
            'resultTotal' => $total,
        ]);

        Log::info('SampleJob: End!!! ' . $time . ' ' . $this->user->name);
    }

    /**
     * チェックポイント送信(WebSocket)
     */
    private function checkPointWs($message, string $detailType, $detail)
    {
        $detail['detailType'] = $detailType;

        $data = [
            "info" => [
                'type' => 'sample_job_progress',
                'title' => $message,
                'detail' => $detail,
            ],
        ];

        $this->webSocketSystemService->publish(ProgressChannel::getChannel($this->user->id), $data);
    }

    /**
     * チェックポイント送信(Push通知)
     */
    private function checkPointPush($title, string $detailType, array $detail)
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
            $title,
            $this->user,
            $options
        );
    }
}
