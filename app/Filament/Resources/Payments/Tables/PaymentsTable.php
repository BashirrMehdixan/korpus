<?php

namespace App\Filament\Resources\Payments\Tables;

use App\Models\Payment;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class PaymentsTable
{
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('index')->label('№')->rowIndex(),
                TextColumn::make('group.name')->label('Qrup')->searchable(),
                TextColumn::make('student.surname')
                    ->label('Tələbə')
                    ->getStateUsing(fn(Payment $record) => "$record->student->surname $record->student->name"),
                TextColumn::make('amount')->label('Məbləğ')->money('AZN'),
                TextColumn::make('paid_at')->label('Ödəniş tarixi')->date(),
                TextColumn::make('month')->label('Ay'),
                TextColumn::make('year')->label('İl'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state) => $state === 'paid' ? 'success' : 'warning'),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ]);
    }
}
