<?php

use Illuminate\Support\Facades\Broadcast;

use Illuminate\Support\Facades\Log;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('TestChannel.{id}', function ($user, $id) {
    Log::info('!!!!!!!!!!!!!!!!! TestChannel.{id}', [$user, $id]);

    return (int) $user->id === (int) $id;
});
