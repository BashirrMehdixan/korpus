<?php

namespace App\Services;

use App\Models\Payment;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;

class FilamentActionsService
{
    public function __construct()
    {
    }

    public static function payMonthlyAmount():Action {
        return Action::make('pay')
            ->label('Ödəniş et')
            ->icon('heroicon-o-banknotes')
            ->color('success')
            ->visible(function (Payment $record): bool {
                if ($record->status === 'paid') return false;

                return !Payment::where('student_id', $record->student_id)
                    ->where('group_id', $record->group_id)
                    ->where('status', '!=', 'paid')
                    ->where('id', '!=', $record->id)
                    ->where(function ($q) use ($record) {
                        if ($record->month !== null && $record->year !== null) {
                            $q->where('year', '<', $record->year)
                                ->orWhere(function ($q) use ($record) {
                                    $q->where('year', '=', $record->year)
                                        ->where('month', '<', $record->month);
                                });
                        } else {
                            $q->where('due_date', '<', $record->due_date)
                                ->orWhereNull('due_date');
                        }
                    })
                    ->exists();
            })
            ->schema([
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
                        if ($record->month !== null && $record->year !== null) {
                            $q->where('year', '>', $record->year)
                                ->orWhere(function ($q) use ($record) {
                                    $q->where('year', '=', $record->year)
                                        ->where('month', '>=', $record->month);
                                });
                        } else {
                            $q->whereNull('month');
                        }
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
            });
    }
}
