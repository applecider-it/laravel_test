<?php

namespace App\Services\Development;

/**
 * ベンチマーク
 */
class BenchmarkService
{
    private array $benchmarkData;

    private $mega = 1024 * 1024;

    private array $keywords = [
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
        $memoryUsed = ($endMemory - $startMemory) / $this->mega;

        $opcacheStatus = opcache_get_status();

        [$keywordResult, $otherVendors, $others, $scriptsTotalMemory] = $this->getOpcacheScriptsDetail($opcacheStatus['scripts']);

        $trace = [
            '処理時間（秒）' => $executionTime,
            'メモリ使用量（MB）' => $memoryUsed,
            'メモリ使用量（MB）開始時' => $startMemory / $this->mega,
            'メモリ使用量（MB）終了時' => $endMemory / $this->mega,
            'opcache使用量（MB）' => $opcacheStatus['memory_usage']['used_memory'] / $this->mega,
            'opcache使用量(スクリプトのみ)（MB）' => $scriptsTotalMemory / $this->mega,
            'opcache使用量(スクリプト以外)（MB）' => ($opcacheStatus['memory_usage']['used_memory'] - $scriptsTotalMemory) / $this->mega,
            'opcache対象ファイル数' => count($opcacheStatus['scripts']),
            'キーワードごとのファイル数' => $keywordResult,
            'その他のベンダーのファイル' => $otherVendors,
            'その他のファイル' => $others,
            'opcache_get_status()' => $opcacheStatus,
        ];

        if ($output) {
            $this->outputHtml($trace);
        }

        return $trace;
    }

    /** Opcacheのスクリプトの詳細 */
    private function getOpcacheScriptsDetail(array $scripts)
    {
        $keywordResult = [];
        $otherVendors = [];
        $others = [];
        $scriptsTotalMemory = 0;

        foreach ($scripts as $key => $row) {
            $scriptsTotalMemory += $row['memory_consumption'];

            // キーワードごとの、カウント
            $found = false;
            foreach ($this->keywords as $keyword) {
                if (strpos($key, $keyword) !== false) {
                    if (!isset($keywordResult[$keyword])) {
                        $keywordResult[$keyword] = [
                            'count' => 0,
                            'memory' => 0,
                        ];
                    }

                    $keywordResult[$keyword]['count']++;
                    $keywordResult[$keyword]['memory'] += $row['memory_consumption'];

                    $found = true;
                    continue;
                }
            }

            // キーワードにないファイルをまとめる
            if (! $found) {
                $val = 'memory(MB): ' . ($row['memory_consumption'] / $this->mega);
                if (strpos($key, 'vendor') !== false) {
                    $otherVendors[$key] = $val;
                } else {
                    $others[$key] = $val;
                }
            }
        }

        // 各種ソート
        ksort($keywordResult);
        ksort($otherVendors);
        ksort($others);

        $keywordResult2 = [];
        foreach ($keywordResult as $key => $row) {
            $keywordResult2[$key] = 'count: ' . $row['count'] . '; memory(MB): ' . ($row['memory'] / $this->mega);
        }

        return [$keywordResult2, $otherVendors, $others, $scriptsTotalMemory];
    }

    /** HTML出力 */
    private function outputHtml(array $trace)
    {
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
}
