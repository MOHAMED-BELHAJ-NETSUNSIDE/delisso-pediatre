<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'image_path', 'stock', 'seuil_alerte', 'active'])]
class Cadeau extends Model
{
    protected $table = 'cadeaux';

    protected function casts(): array
    {
        return [
            'stock' => 'integer',
            'seuil_alerte' => 'integer',
            'active' => 'boolean',
        ];
    }

    public function mouvements(): HasMany
    {
        return $this->hasMany(StockMouvement::class);
    }
}
