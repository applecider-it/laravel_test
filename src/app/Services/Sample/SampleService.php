<?php

namespace App\Services\Sample;

/**
 * サービスクラスのサンプル
 */
class SampleService
{
    public function __construct(
        private SampleService\SubService $subService
    ) {}

    /**
     * テストメソッド
     */
    public function testExec(string $val)
    {
        $this->subService->testExec($val);
    }
}
