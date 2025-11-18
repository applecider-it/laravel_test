<?php

namespace App\Services\Sample\SampleService;

use Illuminate\Support\Facades\Log;

/**
 * サービスクラスのサブクラスのサンプル
 */
class SubService
{
    /**
     * テストメソッド
     */
    public function testExec(string $val)
    {
        Log::info('testExec!! ' . $val);
    }
}
