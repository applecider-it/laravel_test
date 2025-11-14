<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

use App\Models\User;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        $user = new User();
        return $schema
            ->components([
                $user->addAdminValidationName(TextInput::make('name')),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                /*
                TextInput::make('password')
                    ->password()
                    ->required(),
                    */
            ]);
    }
}
