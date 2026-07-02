<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
class PaymentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Ödəniş məlumatları')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('group.name')->label('Qrup'),
                        TextEntry::make('student.surname')
                            ->label('Tələbə')
                            ->getStateUsing(fn($record) => "$record->student->surname $record->student->name"),
                        TextEntry::make('amount')->label('Məbləğ')->money('AZN'),
                        TextEntry::make('paid_at')->label('Ödəniş tarixi'),
                        TextEntry::make('month')->label('Ay'),
                        TextEntry::make('year')->label('İl'),
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->getStateUsing(fn($state) => $state === 'paid' ? 'Ödənildi' : 'Gözləyir'),
                        TextEntry::make('note')->label('Qeyd'),
                    ]),
            ]);
    }
}
