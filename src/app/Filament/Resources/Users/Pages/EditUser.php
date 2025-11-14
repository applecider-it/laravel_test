<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Log;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    /** 保存前にデータを加工する */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['name'] = strtoupper($data['name']);
        return $data;
    }

    /** 保存後処理 */
    protected function afterSave(): void
    {
        // 独自処理
        $user = $this->record; // 編集されたモデル
        Log::info("ユーザー {$user->name} が更新されました");

        // フォームの値を最新のDB値で更新
        $this->form->fill([
            'name' => $this->record->name,
            'email' => $this->record->email,
            'email_verified_at' => $this->record->email_verified_at,
        ]);
    }
}
