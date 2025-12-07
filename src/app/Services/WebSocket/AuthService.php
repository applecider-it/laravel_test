<?php

namespace App\Services\WebSocket;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

use App\Models\User;

/**
 * WebSocketの認証管理
 * 
 * JWTのsubがIDに相当する
 */
class AuthService
{
    private const ALGORITHM = 'HS256';

    /**
     * ユーザー用のWebSocket用のJWT生成
     */
    public function createUserJwt(User $user, string $channel)
    {
        $token = JWT::encode([
            'sub' => $user->id,
            'name' => $user->name,
            'channel' => $channel,
            'iat' => time(),
            'exp' => time() + 60 * 60 * 12, // 12時間
        ], config('myapp.ws_jwt_secret'), self::ALGORITHM);

        return $token;
    }

    /**
     * WebSocket用のJWTを解析して情報ハッシュを返す
     * 
     * 失敗時はnullを返す。
     */
    public function parseJwt($token)
    {
        try {
            $payload = JWT::decode($token, new Key(config('myapp.ws_jwt_secret'), self::ALGORITHM));
            $sub = $payload->sub;
            $name = $payload->name;
            $channel = $payload->channel;

            return [
                'id' => $sub,
                'name' => $name,
                'channel' => $channel,
            ];
        } catch (\Exception $e) {
            return null;
        }
    }
}
