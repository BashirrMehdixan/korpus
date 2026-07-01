<?php

namespace App\Filament\Resources\ActiveStudents\Schemas;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->required(),

                TextInput::make('email')
                    ->label('Email')
                    ->required(),

                DatePicker::make('email_verified_at')
                    ->label('Email Verified Date'),

                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required(),

                TextEntry::make('created_at')
                    ->label('Created Date')
                    ->dateTime(),

                TextEntry::make('updated_at')
                    ->label('Last Modified Date')
                    ->dateTime(),

                TextInput::make('surname')
                    ->label('Surname'),

                TextInput::make('patronymic')
                    ->label('Patronymic'),

                TextInput::make('phone')
                    ->label('Phone'),

                DatePicker::make('registration_date')
                    ->label('Registration Date'),

                Checkbox::make('status')
                    ->label('Status'),

                TextInput::make('username')
                    ->label('Username'),
            ]);
    }
}
