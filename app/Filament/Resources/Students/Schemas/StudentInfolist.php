<?php

namespace App\Filament\Resources\Students\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class StudentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('Id'),

                TextEntry::make('name')
                    ->label('Name'),

                TextEntry::make('email')
                    ->label('Email'),

                TextEntry::make('email_verified_at')
                    ->label('Email Verified Date')
                    ->dateTime(),

                TextEntry::make('created_at')
                    ->label('Created Date')
                    ->dateTime(),

                TextEntry::make('updated_at')
                    ->label('Last Modified Date')
                    ->dateTime(),

                TextEntry::make('surname')
                    ->label('Surname'),

                TextEntry::make('patronymic')
                    ->label('Patronymic'),

                TextEntry::make('phone')
                    ->label('Phone'),

                TextEntry::make('registration_date')
                    ->label('Registration Date')
                    ->dateTime(),

                TextEntry::make('status')
                    ->label('Status'),

                TextEntry::make('username')
                    ->label('Username'),
            ]);
    }
}
