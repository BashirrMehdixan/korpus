<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;
use Spatie\Translatable\HasTranslations;

class Course extends Model
{
    use HasUuids, Userstamps, SoftDeletes, HasTranslations;

    public $translatable = ['name', 'description'];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }
}
