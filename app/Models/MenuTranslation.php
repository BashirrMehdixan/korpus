<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['menu_id', 'locale', 'title'])]
class MenuTranslation extends Model
{
    use HasUuids;

    public $timestamps = true;
}
