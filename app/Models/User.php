<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Mattiverse\Userstamps\Traits\Userstamps;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'surname', 'patronymic', 'username', 'phone', 'registration_date', 'email', 'password', 'status'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, Userstamps, SoftDeletes;

    public function groupsTeaching(): HasMany
    {
        return $this->hasMany(Group::class, 'teacher_id');
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_student', 'student_id', 'group_id')
            ->withPivot('enrolled_at')
            ->withTimestamps();
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'student_id');
    }

    public function getFullNameCustomAttribute(): string
    {
        return "{$this->surname} {$this->name}";
    }

    public function teacherPaymentTypes(): HasMany
    {
        return $this->hasMany(TeacherPaymentType::class, 'teacher_id');
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'registration_date' => 'datetime',
            'status' => 'boolean'
        ];
    }
}
