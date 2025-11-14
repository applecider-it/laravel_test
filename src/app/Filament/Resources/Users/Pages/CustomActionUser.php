<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Resources\Pages\Page;
use Filament\Notifications\Notification;

class CustomActionUser extends Page
{
    protected static string $resource = UserResource::class; // Resource に紐づけ

    protected string $view = 'filament.resources.users.pages.custom-action-user';
    protected static ?string $slug = 'custom_action';

    public User $user;

    // Resource の record パラメータを受け取る
    public function mount($record): void
    {
        $this->user = User::findOrFail($record); // IDで取得
    }

    public function performAction()
    {
        //$this->notify('success', 'ユーザーの投稿は' . $this->user->tweets()->count() . '件。');

        // 通知を表示
        Notification::make()
            ->title('ユーザーの投稿は' . $this->user->tweets()->count() . '件。')
            ->success()
            ->send();
    }
}
