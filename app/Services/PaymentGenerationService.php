<?php

namespace App\Services;

use App\Models\Group;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;

class PaymentGenerationService
{
    public function generateForGroup(Group $group, array $studentIds): void
    {
        foreach ($studentIds as $studentId) {
            if ($group->payment_method === 1) {
                if (!$group->fixed_amount) {
                    continue;
                }

                Payment::firstOrCreate([
                    'group_id' => $group->id,
                    'student_id' => $studentId,
                    'month' => null,
                    'year' => null,
                ], [
                    'amount' => $group->fixed_amount,
                    'status' => 'pending',
                    'paid_at' => null,
                    'due_date' => $group->start_date ? Carbon::parse($group->start_date)->addMonth()->endOfMonth() : null,
                ]);
            } elseif ($group->payment_method === 2 && $group->monthly_amount) {
                $start = Carbon::parse($group->start_date);
                $end = $group->end_date ? Carbon::parse($group->end_date) : $start->copy()->addMonth();
                $months = $start->diffInMonths($end) + 1;

                for ($i = 0; $i < $months; $i++) {
                    $date = $start->copy()->addMonthsNoOverflow($i);

                    Payment::firstOrCreate([
                        'group_id' => $group->id,
                        'student_id' => $studentId,
                        'month' => $date->month,
                        'year' => $date->year,
                    ], [
                        'amount' => $group->monthly_amount,
                        'status' => 'pending',
                        'paid_at' => null,
                        'due_date' => $date->copy()->addMonth()->endOfMonth(),
                    ]);
                }
            }
        }
    }

    public function removeForGroup(Group $group, array $studentIds): void
    {
        Payment::where('group_id', $group->id)
            ->whereIn('student_id', $studentIds)
            ->where('status', 'pending')
            ->whereNull('paid_amount')
            ->delete();
    }

    public function regenerateForGroup(Group $group, array $oldStudentIds, array $newStudentIds): void
    {
        $added = array_diff($newStudentIds, $oldStudentIds);
        $removed = array_diff($oldStudentIds, $newStudentIds);

        if (!empty($added)) {
            $this->generateForGroup($group, $added);
        }

        if (!empty($removed)) {
            $this->removeForGroup($group, $removed);
        }
    }
}
