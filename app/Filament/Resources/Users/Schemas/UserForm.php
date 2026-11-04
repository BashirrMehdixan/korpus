<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Filament\Forms\Components\DateTimePicker;
use App\Filament\Forms\Components\Select;
use App\Filament\Forms\Components\TextInput;
use App\Filament\Forms\Components\ToggleButtons;
use App\Filament\Schemas\Components\JsForm;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Role;

class UserForm
{
    public static function configure(Schema $schema, ?string $defaultRole = null): Schema
    {
        return $schema
            ->components([
                JsForm::make()
                    ->columnSpanFull()
                    ->schema([
                        Section::make('Şəxsi məlumatlar')
                            ->description('İstifadəçinin əsas və autentifikasiya məlumatları')
                            ->columns(3)
                            ->columnSpanFull()
                            ->schema([
                                TextInput::make('name')
                                    ->label('Ad')
                                    ->placeholder('Adınızı daxil edin')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(1),
                                TextInput::make('surname')
                                    ->label('Soyad')
                                    ->placeholder('Soyadınızı daxil edin')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(1),
                                TextInput::make('patronymic')
                                    ->label('Ata adı')
                                    ->placeholder('Ata adını daxil edin')
                                    ->maxLength(255)
                                    ->columnSpan(1),
                                TextInput::make('username')
                                    ->label('İstifadəçi adı')
                                    ->placeholder('İstifadəçi adı')
                                    ->maxLength(255)
                                    ->columnSpan(1),
                                TextInput::make('phone')
                                    ->label('Telefon nömrəsi')
                                    ->placeholder('+994')
                                    ->tel()
                                    ->required()
                                    ->maxLength(50)
                                    ->columnSpan(1),
                                TextInput::make('email')
                                    ->label('E-poçt')
                                    ->placeholder('example@mail.com')
                                    ->email()
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(1),
                                TextInput::make('password')
                                    ->label('Şifrə')
                                    ->placeholder('••••••••')
                                    ->password()
                                    ->required(fn(string $context = 'create') => $context === 'create')
                                    ->maxLength(255)
                                    ->columnSpan(1),
                                Select::make('roles')
                                    ->label('Rollar')
                                    ->placeholder('Rol seçin...')
                                    ->options(function () {
                                        try {
                                            $user = auth()->user();
                                            $rolesQuery = Role::query();
                                            if (! ($user && $user->hasRole('super_admin'))) {
                                                $rolesQuery->where('name', '!=', 'super_admin');
                                            }
                                            return $rolesQuery->pluck('name', 'id')->toArray();
                                        } catch (\Throwable) {
                                            return [];
                                        }
                                    })
                                    ->multiple()
                                    ->searchable()
                                    ->default(function () use ($defaultRole) {
                                        if (! $defaultRole) return [];
                                        try {
                                            $id = Role::whereRaw('LOWER(name) = ?', [strtolower($defaultRole)])->value('id')
                                                ?: Role::where('name', $defaultRole)->value('id');
                                            return $id ? [$id] : [];
                                        } catch (\Throwable) {
                                            return [];
                                        }
                                    })
                                    ->columnSpan(1),
                                DateTimePicker::make('registration_date')
                                    ->label('Qeydiyyat tarixi')
                                    ->default(now()->format('Y-m-d H:i'))
                                    ->columnSpan(1),
                                ToggleButtons::make('status')
                                    ->label('Aktivlik')
                                    ->options([
                                        1 => 'Aktiv',
                                        0 => 'Deaktiv',
                                    ])
                                    ->default(1)
                                    ->columnSpan(1),
                            ]),
                    ]),
            ]);
    }
}
