<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Resources\Pages\Page;
use Filament\Notifications\Notification;
use Filament\Actions\Action;

class CustomActionUser extends Page
{
    protected static string $resource = UserResource::class; // Resource に紐づけ

    protected string $view = 'filament.resources.users.pages.custom-action-user';
    //protected static ?string $slug = 'custom_action';

    protected static ?string $title = 'カスタムアクションページ';

    public User $user;

    // Resource の record パラメータを受け取る
    public function mount($record): void
    {
        $this->user = User::findOrFail($record); // IDで取得
    }

    public function getHeaderActions(): array
    {
        return [
            Action::make('viewUser')
                ->label('詳細ページへ')
                ->url(fn(): string => route('filament.admin.resources.users.view', ['record' => $this->user->id]))
                ->icon('heroicon-o-eye'),
        ];
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
