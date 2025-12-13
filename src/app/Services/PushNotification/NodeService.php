<?php

namespace App\Services\PushNotification;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

use App\Models\User;
use App\Models\PushNotification;

/**
 * プッシュ通知のnodeとの連携管理
 */
class NodeService
{
    const string PUSH_QUEUE_REDIS_KEY = 'push_queue';

    const string PUSH_QUEUE_REDIS_KEY_RESULT = 'push_queue_result';

    public function __construct(
        private UpdateService $updateService,
    ) {}

    /**
     * Userモデルからnode用のRedisに積む
     * 
     * 現在のキューの数を返す。
     */
    public function pushByUser($title, User $user, array $options = []): int|null
    {
        if (! $user->push_notification) return null;

        $pushNotifications = $user->pushNotifications()->take(3)->get();

        $cnt = 0;
        foreach ($pushNotifications as $pushNotification) {
            $cnt = $this->pushByPushNotification(
                $title,
                $pushNotification,
                $options
            );
        }

        return $cnt;
    }

    /**
     * PushNotificationモデルからnode用のRedisに積む
     * 
     * 現在のキューの数を返す。
     */
    private function pushByPushNotification($title, PushNotification $notification, array $options): int
    {
        $data = [
            'title' => $title,
            'options' => $options,
            'endpoint' => $notification->endpoint,
            'p256dh' => $notification->p256dh,
            'auth' => $notification->auth,
            'id' => $notification->id
        ];

        //print_r($data);

        return Redis::rpush(self::PUSH_QUEUE_REDIS_KEY, json_encode($data));
    }

    /**
     * キューをクリアする
     */
    public function clear(): void
    {
        Redis::del(self::PUSH_QUEUE_REDIS_KEY);
    }

    /**
     * プッシュ通知の結果を処理する
     */
    public function revievePushNotificationResults()
    {
        $results = [];
        foreach (range(1, 1000) as $num) {
            $val = Redis::lpop(self::PUSH_QUEUE_REDIS_KEY_RESULT);

            // 空になったら終了
            if (! $val) break;

            Log::info("popPushNotificationResults: loop: num: {$num}: val: {$val}");

            $data = json_decode($val, true);

            $results[] = $data;

            $id = $data['id'];
            $status = $data['status'];

            $pushNotification = PushNotification::find($id);

            $this->updateService->autoDelete($pushNotification, $status);
        }

        return $results;
    }
}
