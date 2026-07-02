<?php

namespace App\Filament\Resources\Students\RelationManagers;

use App\Models\Payment;
use App\Services\FilamentActionsService;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->modifyQueryUsing(function (Builder $query) {
                return $query
                    ->orderByRaw('due_date >= NOW() DESC')
                    ->orderBy('due_date', 'asc');
            })
            ->columns([
                TextColumn::make('group.name')
                    ->label(__('main.group')),
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
            ])
            ->defaultSort('due_date', 'desc')
            ->defaultKeySort(false)
            ->filters([
                TrashedFilter::make()->native(false),
                SelectFilter::make('status')->options([
                    'pending' => __('main.pending'),
                    'partial' => __('main.partial'),
                    'paid' => __('main.paid'),
                ])->native(false)
            ])
            ->recordActions([
                FilamentActionsService::payMonthlyAmount()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn(Builder $query) => $query->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]));
    }
}
