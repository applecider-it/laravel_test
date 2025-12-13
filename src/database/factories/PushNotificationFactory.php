<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PushNotification>
 */
class PushNotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'endpoint' => Str::random(10),
            'p256dh' => Str::random(10),
            'auth' => Str::random(10),
            'user_id' => 1,
        ];
    }
}
