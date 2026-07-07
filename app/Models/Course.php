<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Mattiverse\Userstamps\Traits\Userstamps;
use Spatie\Translatable\HasTranslations;

class Course extends Model
{
    use HasUuids, Userstamps, SoftDeletes, HasTranslations;

    public array $translatable = ['name', 'description'];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $course) {
            if (!$course->slug) {
                $course->slug = Str::slug($course->getTranslations('name')['az'] ?? '');
            }
        });
    }

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }

    protected function casts(): array
    {
        return [
            'name' => 'json',
            'description' => 'json',
            'status' => 'boolean',
        ];
    }
}
