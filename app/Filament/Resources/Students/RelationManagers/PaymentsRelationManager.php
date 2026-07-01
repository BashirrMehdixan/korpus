<?php

namespace App\Filament\Resources\Students\RelationManagers;

use App\Models\Payment;
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
                    ->label('Qrup')
                    ->label('Aylıq məbləğ')
                    ->money('AZN'),
                TextColumn::make('paid_amount')
                    ->label('Ödənilən')
                    ->money('AZN')
                    ->placeholder('-'),
                TextColumn::make('paid_at')
                    ->label('Ödəniş tarixi')
                    ->date()
                    ->placeholder('Ödənilməyib'),
                TextColumn::make('due_date')
                    ->label('Son ödəniş tarixi')
                    ->date()
                    ->color(fn($state, $record) => $record->status !== 'paid' && $record->due_date && $record->due_date->isPast() ? 'danger' : null),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(function ($state, $record) {
                        if ($state === 'paid') {
                            return 'Ödənildi';
                        }

                        if ($record->due_date && $record->due_date->isPast()) {
                            return 'Gecikmiş';
                        }

                        return match ($state) {
                            'pending' => 'Gözləmədə',
                            'partial' => 'Qismən',
                            default => $state,
                        };
                    })
                    ->color(function ($state, $record) {
                        if ($record->status === 'paid') {
                            return 'success';
                        }

                        if ($record->due_date && $record->due_date->isPast()) {
                            return 'danger';
                        }

                        return match ($record->status) {
                            'partial' => 'info',
                            default => 'warning',
                        };
                    }),
            ])
            ->defaultSort('year', 'desc')
            ->defaultKeySort(false)
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                Action::make('pay')
                    ->label('Ödəniş et')
                    ->icon('heroicon-o-banknotes')
                    ->color('success')
                    ->visible(function (Payment $record): bool {
                        if ($record->status === 'paid') {
                            return false;
                        }

                        return !Payment::where('student_id', $record->student_id)
                            ->where('group_id', $record->group_id)
                            ->where('status', '!=', 'paid')
                            ->where(function ($q) use ($record) {
                                $q->where('year', '<', $record->year)
                                    ->orWhere(function ($q) use ($record) {
                                        $q->where('year', '=', $record->year)
                                            ->where('month', '<', $record->month);
                                    });
                            })
                            ->exists();
                    })
                    ->form([
                        TextInput::make('paid_amount')
                            ->label('Ödənilən məbləğ (AZN)')
                            ->numeric()
                            ->required()
                            ->minValue(0),
                        DatePicker::make('paid_at')
                            ->label('Ödəniş tarixi')
                            ->required()
                            ->default(now()),
                    ])
                    ->action(function (Payment $record, array $data) {
                        $paidAmount = $data['paid_amount'];
                        $paidAt = $data['paid_at'];
                        $remaining = $paidAmount;

                        $pendingPayments = Payment::where('student_id', $record->student_id)
                            ->where('group_id', $record->group_id)
                            ->whereIn('status', ['pending', 'partial'])
                            ->where(function ($q) use ($record) {
                                $q->where('year', '>', $record->year)
                                    ->orWhere(function ($q) use ($record) {
                                        $q->where('year', '=', $record->year)
                                            ->where('month', '>=', $record->month);
                                    });
                            })
                            ->orderBy('year')
                            ->orderBy('month')
                            ->get();

                        foreach ($pendingPayments as $payment) {
                            if ($remaining <= 0) {
                                break;
                            }

                            $due = $payment->amount - ($payment->paid_amount ?? 0);

                            if ($remaining >= $due) {
                                $payment->update([
                                    'paid_amount' => $payment->amount,
                                    'paid_at' => $paidAt,
                                    'status' => 'paid',
                                ]);
                                $remaining -= $due;
                            } else {
                                $newPaid = ($payment->paid_amount ?? 0) + $remaining;
                                $payment->update([
                                    'paid_amount' => $newPaid,
                                    'paid_at' => $paidAt,
                                    'status' => $newPaid >= $payment->amount ? 'paid' : 'partial',
                                ]);
                                $remaining = 0;
                            }
                        }

                        if ($remaining > 0) {
                            Notification::make()
                                ->warning()
                                ->title("$remaining AZN artıq ödəniş növbəti aylara köçürüldü")
                                ->send();
                        }

                        Notification::make()
                            ->success()
                            ->title('Ödəniş qeydə alındı')
                            ->send();
                    }),
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
