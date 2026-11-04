<?php

namespace App\Filament\Resources\Payments\Schemas;

use App\Filament\Forms\Components\DatePicker;
use App\Filament\Forms\Components\Select;
use App\Filament\Forms\Components\Textarea;
use App\Filament\Forms\Components\TextInput;
use App\Filament\Schemas\Components\JsForm;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                JsForm::make()
                    ->columnSpanFull()
                    ->schema([
                        Section::make(__('main.payment_info'))
                            ->columnSpanFull()
                            ->columns(2)
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
                                    ->default(now()->format('Y-m-d')),
                                Textarea::make('note')
                                    ->label(__('main.note'))
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }
}
