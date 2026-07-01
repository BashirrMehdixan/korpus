<?php

namespace App\Filament\Resources\Payments\Tables;

use App\Models\Payment;
use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
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
                    ->getStateUsing(fn(Payment $record) => $record->student->getFullNameCustomAttribute()),
                TextColumn::make('amount')->label('Məbləğ')->money('AZN'),
                TextColumn::make('paid_at')->label('Ödəniş tarixi')->date(),
                TextColumn::make('month')->label('Ay'),
                TextColumn::make('year')->label('İl'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state) => $state === 'paid' ? 'success' : 'warning'),
            ])->defaultSort('due_date')
            ->filters([
                TrashedFilter::make()->native(false),
                SelectFilter::make('student_id')
                    ->label('Tələbə')
                    ->options(fn() => User::whereHas('payments')
                        ->get()
                        ->pluck('full_name_custom', 'id')
                    )
                    ->searchable()
                    ->preload()
                    ->native(false),
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
