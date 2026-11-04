<?php

namespace App\Filament\Resources\Payments\Schemas;

use App\Filament\Infolists\Components\JsInfolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PaymentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                JsInfolist::make()
                    ->columnSpanFull()
                    ->schema([
                        Section::make('Ödəniş məlumatları')
                            ->columns(2)
                            ->schema([
                                TextEntry::make('group.name')->label('Qrup'),
                                TextEntry::make('student.surname')
                                    ->label('Tələbə')
                                    ->getStateUsing(fn($record) => $record && $record->student ? "{$record->student->surname} {$record->student->name}" : '-'),
                                TextEntry::make('amount')->label('Məbləğ')->getStateUsing(fn($record) => $record ? "{$record->amount} AZN" : '-'),
                                TextEntry::make('paid_at')->label('Ödəniş tarixi'),
                                TextEntry::make('month')->label('Ay'),
                                TextEntry::make('year')->label('İl'),
                                TextEntry::make('status')
                                    ->label('Status')
                                    ->badge()
                                    ->getStateUsing(fn($state) => $state === 'paid' ? 'Ödənildi' : 'Gözləyir'),
                                TextEntry::make('note')->label('Qeyd'),
                            ]),
                    ]),
            ]);
    }
}
