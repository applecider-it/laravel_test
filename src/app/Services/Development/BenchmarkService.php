<?php

namespace App\Services\Development;

/**
 * ベンチマーク
 */
class BenchmarkService
{
    private array $benchmarkData;

    function __construct()
    {
        $this->benchmarkData = [
            'startTime' => microtime(true),
            'startMemory' => memory_get_usage(),
        ];
    }

    /** ベンチマークの結果を表示 */
    public function closeBenchmark(bool $output = true)
    {
        $startTime = $this->benchmarkData['startTime'];
        $startMemory = $this->benchmarkData['startMemory'];

        $endTime = microtime(true);
        $endMemory = memory_get_usage();

        $executionTime = $endTime - $startTime;
        $memoryUsed = ($endMemory - $startMemory) / 1024 / 1024; // MB単位

        $opcacheStatus = opcache_get_status();

        [$keywordResult, $otherVendors, $others] = $this->getOpcacheScriptsDetail($opcacheStatus['scripts']);

        $trace = [
            '処理時間（秒）' => $executionTime,
            'メモリ使用量（MB）' => $memoryUsed,
            'メモリ使用量（MB）開始時' => $startMemory / 1024 / 1024,
            'メモリ使用量（MB）終了時' => $endMemory / 1024 / 1024,
            'opcache使用量（MB）' => $opcacheStatus['memory_usage']['used_memory'] / 1024 / 1024,
            'opcache対象ファイル数' => count($opcacheStatus['scripts']),
            'キーワードごとのファイル数' => $keywordResult,
            'その他のベンダーのファイル' => $otherVendors,
            'その他のファイル' => $others,
            //'opcache_get_status()' => $opcacheStatus,
        ];

        if ($output) {
            $out = '
                <div style="font-size: 0.7rem;">
                    <div>--------------- performance trace begin ---------------</div>
                        <div>performance:</div>
                        <pre>' . json_encode($trace, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</pre>
                    <div>--------------- performance trace end ---------------</div>
                </div>
            ';

            echo $out;
        }

        return $trace;
    }

    /** Opcacheのスクリプトの詳細 */
    private function getOpcacheScriptsDetail(array $scripts)
    {
        $keywords = [
            'vendor/illuminate',
            'vendor/symfony',
            'vendor/laminas',
            'vendor/doctrine',
            'vendor/vlucas',
            'vendor/composer',
            'vendor/barryvdh',
            'vendor/dragon-code',
            'vendor/guzzlehttp',
            'vendor/laravel-lang',
            'vendor/laravel',
            'vendor/monolog',
            'vendor/nesbot',
            'vendor/pestphp',
            'vendor/php-debugbar',
            'vendor/phpunit',
        ];

        $keywordResult = [];
        $otherVendors = [];
        $others = [];

        foreach ($scripts as $key => $val) {
            $found = false;
            foreach ($keywords as $keyword) {
                if (strpos($key, $keyword) !== false) {
                    if (!isset($keywordResult[$keyword])) $keywordResult[$keyword] = 0;
                    $keywordResult[$keyword]++;
                    $found = true;
                    continue;
                }
            }

            if (! $found) {
                if (strpos($key, 'vendor') !== false) {
                    $otherVendors[] = $key;
                } else {
                    $others[] = $key;
                }
            }
        }

        ksort($keywordResult);
        sort($otherVendors);
        sort($others);

        return [$keywordResult, $otherVendors, $others];
    }
}
