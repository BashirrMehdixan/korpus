<?php

namespace App\Filament\Resources\Groups\Schemas;

use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class GroupInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Qrup məlumatları')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')->label('Ad'),
                        TextEntry::make('slug')->label('Slug'),
                        TextEntry::make('course.name')->label('Kurs'),
                        TextEntry::make('teacher.surname')
                            ->label('Müəllim')
                            ->getStateUsing(fn($record) => "$record->teacher->surname $record->teacher->name"),
                        TextEntry::make('start_date')->label('Başlama tarixi'),
                        TextEntry::make('end_date')->label('Bitmə tarixi'),
                        TextEntry::make('payment_method')
                            ->label('Ödəniş üsulu')
                            ->getStateUsing(fn($state) => $state === 1 ? 'Birdəfəlik' : 'Aylıq'),
                        TextEntry::make('amount')
                            ->label('Məbləğ (AZN)')
                            ->getStateUsing(fn($record) => $record->payment_method === 1 ? $record->fixed_amount : $record->monthly_amount)
                            ->money('AZN'),
                        TextEntry::make('status')
                            ->label('Aktivlik')
                            ->badge()
                            ->getStateUsing(fn($state) => $state ? 'Aktiv' : 'Passiv'),
                    ]),
                Section::make('Tələbələr')
                    ->schema([
                        TextEntry::make('students')
                            ->label('Tələbələr')
                            ->getStateUsing(fn($record) => $record->students->map(
                                fn($s) => "$s->surname $s->name $s->patronymic"
                            )->implode(', ')),
                    ]),
            ]);
    }
}
