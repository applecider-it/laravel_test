<?php

namespace App\Services\PushNotification;

use Illuminate\Support\Facades\Log;

use App\Models\PushNotification;

/**
 * プッシュ通知の更新関連
 */
class UpdateService
{
    /**
     * オート削除
     * 
     * 失敗したときは、失敗数を数えて、リミットを超えたら削除。
     * 成功時には、リミットをリセットする。
     */
    public function autoDelete(PushNotification $pushNotification, bool $status)
    {
        if ($status) {
            if ($pushNotification->failure_count > 0) {
                $pushNotification->failure_count = 0;
                $pushNotification->save();
            }
        } else {
            Log::info("sendByPushNotification: status ng !!!!!");

            if ($pushNotification->failure_count >= config('myapp.push_notification_failure_limit')) {
                $pushNotification->delete();
            } else {
                $pushNotification->failure_count++;
                $pushNotification->save();
            }
        }
    }
}
