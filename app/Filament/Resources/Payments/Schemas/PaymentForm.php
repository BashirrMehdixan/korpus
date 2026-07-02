<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Ödəniş məlumatları')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        Select::make('group_id')
                            ->label('Qrup')
                            ->relationship('group', 'name')
                            ->required()
                            ->preload()
                            ->disabled()
                            ->searchable(),
                        Select::make('student_id')
                            ->label('Tələbə')
                            ->relationship('student', 'surname')
                            ->getOptionLabelFromRecordUsing(fn($record) => "$record->surname $record->name $record->patronymic")
                            ->required()
                            ->preload()
                            ->disabled()
                            ->searchable(),
                        TextInput::make('amount')
                            ->label('Məbləğ')
                            ->required()
                            ->numeric()
                            ->prefix('AZN'),
                        DatePicker::make('paid_at')
                            ->label('Ödəniş tarixi')
                            ->required()
                            ->default(now()),
                        Textarea::make('note')
                            ->label('Qeyd')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
