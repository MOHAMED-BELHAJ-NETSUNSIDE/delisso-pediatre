<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['visite_id', 'path', 'sort_order'])]
class VisitePhoto extends Model
{
    protected $table = 'visite_photos';

    public function visite(): BelongsTo
    {
        return $this->belongsTo(Visite::class);
    }
}
