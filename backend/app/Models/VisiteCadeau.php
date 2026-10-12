<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['visite_id', 'cadeau_id', 'qty'])]
class VisiteCadeau extends Model
{
    public $timestamps = false;

    protected $table = 'visite_cadeaux';

    protected function casts(): array
    {
        return [
            'qty' => 'integer',
        ];
    }

    public function visite(): BelongsTo
    {
        return $this->belongsTo(Visite::class);
    }

    public function cadeau(): BelongsTo
    {
        return $this->belongsTo(Cadeau::class);
    }
}
