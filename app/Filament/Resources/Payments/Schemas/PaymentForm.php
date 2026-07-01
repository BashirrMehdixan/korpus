<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Section;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Ödəniş məlumatları')
                    ->columns(2)
                    ->schema([
                        Select::make('group_id')
                            ->label('Qrup')
                            ->relationship('group', 'name')
                            ->required()
                            ->preload()
                            ->searchable(),
                        Select::make('student_id')
                            ->label('Tələbə')
                            ->relationship('student', 'surname')
                            ->getOptionLabelFromRecordUsing(fn($record) => "$record->surname $record->name $record->patronymic")
                            ->required()
                            ->preload()
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
                        Select::make('month')
                            ->label('Ay')
                            ->options([
                                1 => 'Yanvar', 2 => 'Fevral', 3 => 'Mart',
                                4 => 'Aprel', 5 => 'May', 6 => 'İyun',
                                7 => 'İyul', 8 => 'Avqust', 9 => 'Sentyabr',
                                10 => 'Oktyabr', 11 => 'Noyabr', 12 => 'Dekabr',
                            ])
                            ->required(),
                        Select::make('year')
                            ->label('İl')
                            ->options(fn() => collect(range(now()->year - 5, now()->year + 1))
                                ->mapWithKeys(fn($year) => [$year => $year]))
                            ->required()
                            ->default(now()->year),
                        ToggleButtons::make('status')
                            ->label('Status')
                            ->options([
                                'paid' => 'Ödənildi',
                                'pending' => 'Gözləyir',
                            ])
                            ->default('paid')
                            ->inline()
                            ->required(),
                        Textarea::make('note')
                            ->label('Qeyd')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
