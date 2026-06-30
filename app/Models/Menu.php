<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mattiverse\Userstamps\Traits\Userstamps;

#[Fillable(['icon', 'route', 'parent_id', 'order', 'status'])]
class Menu extends Model
{
    use HasFactory, Userstamps, HasUuids;

    public function translations(): HasMany
    {
        return $this->hasMany(MenuTranslation::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order');
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id')->orderBy('order');
    }

    public function translation(?string $locale = null)
    {
        $locale ??= app()->getLocale();
        return $this->translations->firstWhere('locale', $locale);
    }

    protected function casts(): array
    {
        return [
            'status' => 'boolean'
        ];
    }
}
