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
     * 全体送信
     */
    public function sendAll($message)
    {
        $notifications = PushNotification::all();

        foreach ($notifications as $notification) {

            $this->send(
                $message,
                $notification->endpoint,
                $notification->p256dh,
                $notification->auth
            );
        }
    }

    /**
     * 送信
     */
    public function send($message, $endpoint, $p256dh, $auth)
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

        //if ($returnVar !== 0) {   // 失敗しても0になるのでこれは使えない
        if (Str::contains($outputAll, 'Error sending push message')) {

            throw new \RuntimeException("Push notification failed: " . $outputAll);
        }
    }
}
