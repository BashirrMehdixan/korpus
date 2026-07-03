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
                    ->columns()
                    ->schema([
                        Section::make('AZ')
                            ->columnSpan(1)
//                            ->translatable()
                            ->schema([
                                TextInput::make('name.az')
                                    ->label(__('main.name'))
                                    ->required()
                                    ->live(onBlur: true),
                                Textarea::make('description.az')
                                    ->label(__('main.description'))
                                    ->rows(5),
                            ]),
//                        Section::make('EN')
//                            ->columnSpan(1)
//                            ->schema([
//                                TextInput::make('name.en')
//                                    ->required()
//                                    ->label('Name'),
//                                Textarea::make('description.en')
//                                    ->label(__('main.description'))
//                                    ->rows(5),
//                            ]),
//                        Section::make('RU')
//                            ->columnSpan(1)
//                            ->schema([
//                                TextInput::make('name.ru')
//                                    ->label('Название'),
//                                Textarea::make('description_ru')
//                                    ->label('Описание')
//                                    ->rows(5),
//                            ]),
                        ToggleButtons::make('status')
                            ->label(__('main.status'))
                            ->boolean()
                            ->grouped()
                            ->default(true)
                            ->inline(),
                    ]),
            ]);
    }
}
