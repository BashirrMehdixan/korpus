<?php

namespace App\Filament\Resources\Payments\Tables;

use App\Models\Group;
use App\Models\Payment;
use App\Models\User;
use App\Services\FilamentActionsService;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class PaymentsTable
{
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('group.name')
                    ->label(__('main.group')),
                TextColumn::make('student_id')
                    ->label(__('main.student'))
                    ->getStateUsing(fn(Payment $record) => $record->student->full_name_custom)
                    ->sortable()
                    ->searchable(['name', 'surname', 'patronymic']),
                TextColumn::make('amount')
                    ->label(__('main.price'))
                    ->money('AZN'),
                TextColumn::make('paid_amount')
                    ->label(__('main.paid_amount'))
                    ->money('AZN')
                    ->placeholder('-'),
                TextColumn::make('paid_at')
                    ->label(__('main.payment_date'))
                    ->date()
                    ->placeholder(__('main.unpaid')),
                TextColumn::make('due_date')
                    ->label(__('main.due_date'))
                    ->date()
                    ->color(fn($state, $record) => $record->status !== 'paid' && $record->due_date && $record->due_date->isPast() ? 'danger' : null),
                TextColumn::make('status')
                    ->label(__('main.status'))
                    ->badge()
                    ->formatStateUsing(function ($state, $record) {
                        if ($state === 'paid') return __('main.paid');

                        if ($record->due_date && $record->due_date->isPast()) return __('main.overdue');

                        return match ($state) {
                            'pending' => __('main.pending'),
                            'partial' => __('main.partial'),
                            default => $state,
                        };
                    })
                    ->color(function ($state, $record) {
                        if ($record->status === 'paid') return 'success';

                        if ($record->due_date && $record->due_date->isPast()) return 'danger';

                        return match ($record->status) {
                            'partial' => 'info',
                            default => 'warning',
                        };
                    }),
            ])->defaultSort('due_date')
            ->filters([
                TrashedFilter::make()->native(false),
                SelectFilter::make('student_id')
                    ->label(__('main.student'))
                    ->options(fn() => User::whereHas('payments')
                        ->get()
                        ->pluck('full_name_custom', 'id')
                    )
                    ->searchable()
                    ->preload()
                    ->native(false),
                SelectFilter::make('group_id')
                    ->label(__('main.group'))
                    ->options(fn() => Group::whereHas('payments')
                        ->get()
                        ->pluck('name', 'id')
                    )
                    ->searchable()
                    ->preload()
                    ->native(false),
            ])
            ->filtersLayout(FiltersLayout::AboveContent)
            ->recordActions([
//                EditAction::make(),
                FilamentActionsService::payMonthlyAmount(),
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
