<?php

namespace App\Services\WebSocket;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * WebSocketの認証管理
 * 
 * JWTのsubがIDに相当する
 */
class AuthService
{
    /**
     * WebSocket用のJWT生成
     */
    public function createJwt($id, $name)
    {
        $token = JWT::encode([
            'sub' => $id,
            'name' => $name,
            'iat' => time(),
            'exp' => time() + 60 * 60 * 12, // 12時間
        ], env('WS_JWT_SECRET'), 'HS256');

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
            $payload = JWT::decode($token, new Key(env('WS_JWT_SECRET'), 'HS256'));
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
