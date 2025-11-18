<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\PushNotification;

class PushNotificationController extends Controller
{
    /** プッシュ通知のテスト用登録処理 */
    public function store(Request $request)
    {
        $all = $request->all();

        Log::info('push_notification all', [$all]);

        PushNotification::create([
            'endpoint' => $all['endpoint'],
            'p256dh' => $all['p256dh'],
            'auth' => $all['auth'],
        ]);

        return response()->json([
            'status' => 'ok',
        ]);
    }
}
