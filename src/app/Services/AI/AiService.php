<?php

namespace App\Services\Ai;

use Illuminate\Support\Facades\Http;

/**
 * AI管理（入れ物だけ）
 */
class AiService
{
    /**
     * テスト用送信
     */
    public function testSend()
    {
        $text = 'Hello AI';

        $host = config('myapp.ai_server_host');

        // FastAPIのエンドポイントにPOST
        $response = Http::post("http://{$host}/predict", [
            'text' => $text
        ]);

        return $response->json();
    }
}
