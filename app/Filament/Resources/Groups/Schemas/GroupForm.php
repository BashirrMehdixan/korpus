<?php

namespace App\Filament\Resources\Groups\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class GroupForm
{
    public static function configure(Schema $schema): Schema
    {
        $user = auth()->user();

        return $schema
            ->components([
                Section::make('Qrup məlumatları')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Ad')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdate(fn(string $operation, $state, $set) => $operation === 'create'
                                ? $set('slug', Str::slug($state))
                                : null),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Select::make('course_id')
                            ->label('Kurs')
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
                                    ->label('Müəllim')
                                    ->relationship('teacher', 'surname')
                                    ->getOptionLabelFromRecordUsing(fn($record) => "$record->surname $record->name")
                                    ->required()
                                    ->preload()
                                    ->searchable(),
                            ]
                        ),
                        DatePicker::make('start_date')
                            ->label('Başlama tarixi')
                            ->required(),
                        DatePicker::make('end_date')
                            ->label('Bitmə tarixi'),
                        ToggleButtons::make('payment_method')
                            ->label('Ödəniş üsulu')
                            ->options([
                                1 => 'Birdəfəlik',
                                2 => 'Aylıq',
                            ])
                            ->default(1)
                            ->inline()
                            ->required(),
                        ToggleButtons::make('status')
                            ->label('Aktivlik')
                            ->boolean()
                            ->default(true)
                            ->inline(),
                    ]),
                Section::make('Tələbələr')
                    ->schema([
                        Select::make('students')
                            ->label('Tələbələr')
                            ->relationship('students', 'surname')
                            ->getOptionLabelFromRecordUsing(fn($record) => "$record->surname $record->name $record->patronymic")
                            ->multiple()
                            ->preload()
                            ->searchable(),
                    ]),
            ]);
    }
}
