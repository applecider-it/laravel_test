<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Services\PushNotification\RegistService;

class PushNotificationController extends Controller
{
    public function __construct(
        private RegistService $registService
    ) {}

    /** プッシュ通知の登録処理 */
    public function store(Request $request)
    {
        $all = $request->all();

        Log::info('push_notification all', [$all]);

        $user = auth()->user();

        $endpoint = $all['endpoint'];
        $p256dh = $all['p256dh'];
        $auth = $all['auth'];

        $this->registService->registPushNotifications($user, $endpoint, $p256dh, $auth);

        return response()->json([
            'status' => 'ok',
        ]);
    }
}
