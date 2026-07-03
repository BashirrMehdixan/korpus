<?php

namespace App\Filament\Resources\Groups\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class GroupForm
{
    public static function configure(Schema $schema): Schema
    {
        $user = auth()->user();

        return $schema
            ->components([
                Section::make(__('main.group_info'))
                    ->columns()
                    ->columnSpan(2)
                    ->schema([
                        TextInput::make('name')
                            ->label(__('main.name'))
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true),
                        Select::make('course_id')
                            ->label(__('main.course'))
                            ->relationship('course', 'name')
                            ->required()
                            ->preload()
                            ->searchable(),
                        ...($user && $user->hasRole('teacher') && !$user->hasRole('super_admin')
                            ? [
                                Hidden::make('teacher_id')
                                    ->default(fn() => $user->id),
                            ]
                            : [
                                Select::make('teacher_id')
                                    ->label(__('main.teacher'))
                                    ->relationship('teacher', 'surname')
                                    ->getOptionLabelFromRecordUsing(fn($record) => "$record->surname $record->name")
                                    ->required()
                                    ->preload()
                                    ->searchable(),
                            ]
                        ),
                        DatePicker::make('start_date')
                            ->label(__('main.start_date'))
                            ->required(),
                        DatePicker::make('end_date')
                            ->label(__('main.end_date')),
                        ToggleButtons::make('payment_method')
                            ->label(__('main.payment_method'))
                            ->options([
                                1 => __('main.one_time'),
                                2 => __('main.monthly'),
                            ])
                            ->default(1)
                            ->inline()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn(callable $set, $state) => $state === 1 ? $set('monthly_amount', null) : $set('fixed_amount', null)),
                        TextInput::make('fixed_amount')
                            ->label(__('main.fixed_amount'))
                            ->numeric()
                            ->visible(fn($get) => $get('payment_method') === 1)
                            ->required(fn($get) => $get('payment_method') === 1),
                        TextInput::make('monthly_amount')
                            ->label(__('main.monthly_amount'))
                            ->numeric()
                            ->visible(fn($get) => $get('payment_method') === 2)
                            ->required(fn($get) => $get('payment_method') === 2),
                        ToggleButtons::make('status')
                            ->label(__('main.status'))
                            ->boolean()
                            ->default(true)
                            ->inline(),
                    ]),
                Section::make(__('main.students'))
                    ->schema([
                        Select::make('students')
                            ->label(__('main.students'))
                            ->relationship('students', 'surname')
                            ->getOptionLabelFromRecordUsing(fn($record) => "$record->surname $record->name $record->patronymic")
                            ->multiple()
                            ->preload()
                            ->searchable(),
                    ])->columnSpan(1),
            ])->columns(3);
    }
}
