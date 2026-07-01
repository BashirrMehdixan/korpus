<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;
use Spatie\Translatable\HasTranslations;

class Course extends Model
{
    use HasUuids, Userstamps, SoftDeletes, HasTranslations, Sluggable;

    public $translatable = ['name', 'description'];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }

    protected function casts(): array
    {
        return [
            'name' => 'json',
            'status' => 'boolean',
        ];
    }
}
