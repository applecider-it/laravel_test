<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class PushNotificationTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:push-notification-test';

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
        $val = Redis::get('push_notification-test');

        if (!$val) return;

        $data = json_decode($val, true);

        $this->info("data: " . print_r($data, true));

        $message = "テスト通知";

        $payload = json_encode(['title' => $message]);

        $cmdParts = [
            'web-push',
            'send-notification',
            '--endpoint=' . escapeshellarg($data['endpoint']),
            '--key=' . escapeshellarg($data['p256dh']),
            '--auth=' . escapeshellarg($data['auth']),
            '--vapid-subject=' . escapeshellarg('mailto:you@example.com'),
            '--vapid-pubkey=' . escapeshellarg(config('myapp.vapid_public_key')),
            '--vapid-pvtkey=' . escapeshellarg(config('myapp.vapid_private_key')),
            '--payload=' . escapeshellarg($payload),
        ];
        
        $cmd = implode(' ', $cmdParts);

        $this->info("cmd: " . $cmd);
        
        exec($cmd, $output, $returnVar);
        
        if ($returnVar !== 0) {
            throw new \RuntimeException("Push notification failed: " . implode("\n", $output));
        }
    }
}
