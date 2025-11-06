<?php

// 開始時
$startTime = microtime(true);
$startMemory = memory_get_usage();

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());

// 終了時
$endTime = microtime(true);
$endMemory = memory_get_usage();

$executionTime = $endTime - $startTime;
$memoryUsed = ($endMemory - $startMemory) / 1024 / 1024; // MB単位

dd([
    '処理時間（秒）' => $executionTime,
    'メモリ使用量（MB）' => $memoryUsed,
    'メモリ使用量（MB）開始時' => $startMemory / 1024 / 1024,
    'メモリ使用量（MB）終了時' => $endMemory / 1024 / 1024,
]);