<?php

namespace App\Filament\Resources\Courses\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make()
                    ->columnSpanFull()
                    ->columns(3)
                    ->schema([
                        Section::make('AZ')
                            ->columnSpan(1)
                            ->schema([
                                TextInput::make('name_az')
                                    ->label('Ad')
                                    ->required()
                                    ->live(onBlur: true),
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
                        ToggleButtons::make('status')
                            ->label('Aktivlik')
                            ->boolean()
                            ->grouped()
                            ->default(true)
                            ->inline(),
                    ]),
            ]);
    }
}
