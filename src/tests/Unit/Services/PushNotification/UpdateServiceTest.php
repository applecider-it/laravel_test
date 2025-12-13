<?php

use App\Models\PushNotification;
use App\Services\PushNotification\UpdateService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;

uses(Tests\TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    config(['myapp.push_notification_failure_limit' => 3]);
});

test('成功時は failure_count が 0 にリセットされる', function () {
    $pushNotification = PushNotification::factory()->create([
        'failure_count' => 2,
    ]);

    $service = new UpdateService();

    $service->autoDelete($pushNotification, true);

    $pushNotification->refresh();

    expect($pushNotification->failure_count)->toBe(0);
});

test('成功時で failure_count が 0 の場合は変更されない', function () {
    $pushNotification = PushNotification::factory()->create([
        'failure_count' => 0,
    ]);

    $service = new UpdateService();

    $service->autoDelete($pushNotification, true);

    $pushNotification->refresh();

    expect($pushNotification->failure_count)->toBe(0);
});

test('失敗時は failure_count がインクリメントされる', function () {
    Log::spy();

    $pushNotification = PushNotification::factory()->create([
        'failure_count' => 1,
    ]);

    $service = new UpdateService();

    $service->autoDelete($pushNotification, false);

    $pushNotification->refresh();

    expect($pushNotification->failure_count)->toBe(2);

    Log::shouldHaveReceived('info')
        ->with('sendByPushNotification: status ng !!!!!')
        ->once();
});

test('失敗回数が上限以上の場合は削除される', function () {
    Log::spy();

    $pushNotification = PushNotification::factory()->create([
        'failure_count' => 3,
    ]);

    $service = new UpdateService();

    $service->autoDelete($pushNotification, false);

    $this->assertSoftDeleted($pushNotification);

    Log::shouldHaveReceived('info')
        ->with('sendByPushNotification: status ng !!!!!')
        ->once();
});
