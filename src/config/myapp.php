<?php
/**
 * アプリケーション独自の設定ファイル
 */

return [
    // 管理画面のURIのプレフィックス
    'admin_uri_prefix' => 'admin_secrettext',

    // WebSocketのJWT認証用のシークレットテキスト
    'ws_jwt_secret' => env('MYAPP_WS_JWT_SECRET'),

    // WebSocketサーバーのホスト名
    'ws_server_host' => env('MYAPP_WS_SERVER_HOST'),

    // AIサーバーのホスト名
    'ai_server_host' => env('MYAPP_AI_SERVER_HOST'),

    // プッシュ通知用のパブリックキー
    'vapid_public_key' => env('MYAPP_VAPID_PUBLIC_KEY'),

    // プッシュ通知用のプライベートキー
    'vapid_private_key' => env('MYAPP_VAPID_PRIVATE_KEY'),
];