<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['cadeau_id', 'type', 'qty', 'user_id', 'visite_id', 'note'])]
class StockMouvement extends Model
{
    protected $table = 'stock_mouvements';

    protected function casts(): array
    {
        return [
            'qty' => 'integer',
        ];
    }

    public function cadeau(): BelongsTo
    {
        return $this->belongsTo(Cadeau::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function visite(): BelongsTo
    {
        return $this->belongsTo(Visite::class);
    }
}
