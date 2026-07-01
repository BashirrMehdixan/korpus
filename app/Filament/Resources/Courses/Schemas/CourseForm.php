<?php

namespace App\Filament\Resources\Courses\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('AZ')
                    ->columnSpan(1)
                    ->schema([
                        TextInput::make('name_az')
                            ->label('Ad')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdate(fn(string $operation, $state, $set) => $operation === 'create'
                                ? $set('slug', Str::slug($state))
                                : null),
                        Textarea::make('description_az')
                            ->label('Təsvir')
                            ->rows(5),
                    ]),
                Section::make('EN')
                    ->columnSpan(1)
                    ->schema([
                        TextInput::make('name_en')
                            ->label('Name'),
                        Textarea::make('description_en')
                            ->label('Description')
                            ->rows(5),
                    ]),
                Section::make('RU')
                    ->columnSpan(1)
                    ->schema([
                        TextInput::make('name_ru')
                            ->label('Название'),
                        Textarea::make('description_ru')
                            ->label('Описание')
                            ->rows(5),
                    ]),
                Section::make('Əsas məlumatlar')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        ToggleButtons::make('status')
                            ->label('Aktivlik')
                            ->boolean()
                            ->default(true)
                            ->inline(),
                    ]),
            ]);
    }
}
