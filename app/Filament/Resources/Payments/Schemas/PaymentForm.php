<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('main.payment_info'))
                    ->columnSpanFull()
                    ->columns()
                    ->schema([
                        Select::make('group_id')
                            ->label(__('main.group'))
                            ->relationship('group', 'name')
                            ->required()
                            ->preload()
                            ->disabled()
                            ->searchable(),
                        Select::make('student_id')
                            ->label(__('main.student'))
                            ->relationship('student', 'surname')
                            ->getOptionLabelFromRecordUsing(fn($record) => "$record->surname $record->name $record->patronymic")
                            ->required()
                            ->preload()
                            ->disabled()
                            ->searchable(),
                        TextInput::make('amount')
                            ->label(__('main.amount'))
                            ->required()
                            ->numeric()
                            ->prefix('AZN'),
                        DatePicker::make('paid_at')
                            ->label(__('main.payment_date'))
                            ->required()
                            ->default(now()),
                        Textarea::make('note')
                            ->label(__('main.note'))
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
