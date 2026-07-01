<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Şəxsi məlumatlar')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('name')->label('Ad'),
                        TextEntry::make('surname')->label('Soyad'),
                        TextEntry::make('patronymic')->label('Ata adı'),
                        TextEntry::make('username')->label('İstifadəçi adı'),
                        TextEntry::make('phone')->label('Telefon'),
                        TextEntry::make('email')->label('E-poçt'),
                        TextEntry::make('registration_date')->label('Qeydiyyat tarixi'),
                        TextEntry::make('status')
                            ->label('Aktivlik')
                            ->badge()
                            ->getStateUsing(fn($state) => $state ? 'Aktiv' : 'Passiv'),
                    ]),
                Section::make('Rollar')
                    ->schema([
                        TextEntry::make('roles.name')
                            ->label('Rollar')
                            ->badge(),
                    ]),
            ]);
    }
}
