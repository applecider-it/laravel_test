<?php

namespace App\Services\PushNotification;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

use App\Models\PushNotification;

/**
 * プッシュ通知の送信関連
 */
class SenderService
{
    /**
     * PushNotificationモデルから送信
     */
    public function send(string $message, PushNotification $notification): array
    {
        return $this->execWebPush(
            $message,
            $notification->endpoint,
            $notification->p256dh,
            $notification->auth
        );
    }

    /**
     * web-pushコマンド実行
     */
    private function execWebPush(string $message, string $endpoint, string $p256dh, string $auth): array
    {
        $payload = json_encode(['title' => $message]);

        $cmdParts = [
            'web-push',
            'send-notification',
            '--endpoint=' . escapeshellarg($endpoint),
            '--key=' . escapeshellarg($p256dh),
            '--auth=' . escapeshellarg($auth),
            '--vapid-subject=' . escapeshellarg('mailto:you@example.com'),
            '--vapid-pubkey=' . escapeshellarg(config('myapp.vapid_public_key')),
            '--vapid-pvtkey=' . escapeshellarg(config('myapp.vapid_private_key')),
            '--payload=' . escapeshellarg($payload),
        ];

        $cmd = implode(' ', $cmdParts);

        Log::info("cmd: " . $cmd);

        exec($cmd, $output, $returnVar);

        $outputAll = implode("\n", $output);

        //print_r([$outputAll, $returnVar]);
        Log::info("result: ", [$outputAll, $returnVar]);

        $status = true;
        //if ($returnVar !== 0) {   // 失敗しても0になるのでこれは使えない
        if (Str::contains($outputAll, 'Error sending push message')) {
            $status = false;
        }

        return [
            'status' => $status,
            'cmd' => $cmd,
            'output' => $outputAll,
            'returnVar' => $returnVar,
        ];
    }
}
