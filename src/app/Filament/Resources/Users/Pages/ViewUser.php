<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            Action::make('customAction')
            ->label('カスタムページへ')
            ->url(fn (): string => route('filament.admin.resources.users.custom-action', ['record' => $this->record->id]))
            //->openUrlInNewTab()   // 新しいタブで開く場合
            , 
        ];
    }
}
