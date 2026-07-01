<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class TeacherPaymentType extends Model
{
    use HasUuids, Userstamps, SoftDeletes;

    protected $fillable = [
        'teacher_id',
        'type',
        'amount',
        'percentage',
        'group_id',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'type' => 'integer',
            'amount' => 'decimal:2',
            'percentage' => 'decimal:2',
            'status' => 'boolean',
        ];
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}
