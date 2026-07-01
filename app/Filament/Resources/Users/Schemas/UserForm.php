<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make()->schema([
                    Section::make('Şəxsi məlumatlar')
                        ->columns(3)
                        ->schema([
                            TextInput::make('name')
                                ->label('Ad')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('surname')
                                ->label('Soyad')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('patronymic')
                                ->label('Ata adı')
                                ->maxLength(255),
                            TextInput::make('username')
                                ->label('İstifadəçi adı')
                                ->unique(ignoreRecord: true)
                                ->maxLength(255),
                            TextInput::make('phone')
                                ->label('Telefon nömrəsi')
                                ->tel()
                                ->maxLength(50),
                            TextInput::make('email')
                                ->label('E-poçt')
                                ->email()
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->maxLength(255),
                            TextInput::make('password')
                                ->label('Şifrə')
                                ->password()
                                ->dehydrated(fn($state) => filled($state))
                                ->required(fn(string $context) => $context === 'create')
                                ->maxLength(255),
                            Select::make('roles')
                                ->label('Rollar')
                                ->relationship(
                                    name: 'roles',
                                    titleAttribute: 'name',
                                    // Baza sorğusunu süzgəcləyirik:
                                    modifyQueryUsing: fn(Builder $query) => auth()->user()->hasRole('super_admin')
                                        ? $query
                                        : $query->where('name', '!=', 'super_admin')
                                )
                                ->multiple()
                                ->preload(),
                            DateTimePicker::make('registration_date')
                                ->label('Qeydiyyat tarixi')
                                ->default(now()),
                            ToggleButtons::make('status')
                                ->label('Aktivlik')
                                ->boolean()
                                ->grouped()
                                ->default(true)
                                ->inline(),
                        ])->columnSpanFull(),
                ])->columnSpanFull()
            ]);
    }
}
