<?php

namespace App\Filament\Resources\Courses\Schemas;

use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CourseInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Kurs məlumatları')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Ad')
                            ->getStateUsing(fn($record) => $record->getTranslation('name', app()->getLocale())),
                        TextEntry::make('name_az')->label('Ad (AZ)')
                            ->getStateUsing(fn($record) => $record->getTranslation('name', 'az')),
                        TextEntry::make('name_en')->label('Name (EN)')
                            ->getStateUsing(fn($record) => $record->getTranslation('name', 'en')),
                        TextEntry::make('name_ru')->label('Название (RU)')
                            ->getStateUsing(fn($record) => $record->getTranslation('name', 'ru')),
                        TextEntry::make('description')
                            ->label('Təsvir')
                            ->getStateUsing(fn($record) => $record->getTranslation('description', app()->getLocale())),
                        TextEntry::make('status')
                            ->label('Aktivlik')
                            ->badge()
                            ->getStateUsing(fn($state) => $state ? 'Aktiv' : 'Passiv'),
                    ]),
            ]);
    }
}
