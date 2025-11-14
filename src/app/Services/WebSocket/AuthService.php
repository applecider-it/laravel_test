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
    public function createUserJwt(User $user)
    {
        $token = JWT::encode([
            'sub' => $user->id,
            'name' => $user->name,
            'iat' => time(),
            'exp' => time() + 60 * 60 * 12, // 12時間
        ], env('WS_JWT_SECRET'), self::ALGORITHM);

        return $token;
    }

    /**
     * システム用のWebSocket用のJWT生成
     * 
     * システム用ではすぐにクローズするので有効期限は短くしている。
     */
    public function createSystemJwt()
    {
        $name = 'System';
        $id = SystemService::SYSTEM_ID;
        $token = JWT::encode([
            'sub' => $id,
            'name' => $name,
            'iat' => time(),
            'exp' => time() + 60, // 1分
        ], env('WS_JWT_SECRET'), self::ALGORITHM);

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
            $payload = JWT::decode($token, new Key(env('WS_JWT_SECRET'), self::ALGORITHM));
            $sub = $payload->sub;
            $name = $payload->name;

            return [
                'id' => $sub,
                'name' => $name,
            ];
        } catch (\Exception $e) {
            return null;
        }
    }
}
