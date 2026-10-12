<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'medecin_id',
    'delegue_id',
    'nvisite',
    'classe',
    'region',
    'municipalite',
    'etab',
    'name_etab',
    'gps',
    'remarque',
])]
class Visite extends Model
{
    protected function casts(): array
    {
        return [
            'nvisite' => 'integer',
            'etab' => 'integer',
        ];
    }

    public function medecin(): BelongsTo
    {
        return $this->belongsTo(Medecin::class);
    }

    public function delegue(): BelongsTo
    {
        return $this->belongsTo(User::class, 'delegue_id');
    }

    public function lignes(): HasMany
    {
        return $this->hasMany(VisiteCadeau::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(VisitePhoto::class)->orderBy('sort_order');
    }

    /**
     * @return array{0: float, 1: float}|null
     */
    public static function coordinates(?string $gps): ?array
    {
        if ($gps === null || ! preg_match('/^\s*(-?\d+(?:\.\d+)?)\s*,\s*(-?\d+(?:\.\d+)?)\s*$/', $gps, $match)) {
            return null;
        }

        $lat = (float) $match[1];
        $lng = (float) $match[2];

        if ($lat < -90 || $lat > 90 || $lng < -180 || $lng > 180) {
            return null;
        }

        return [$lat, $lng];
    }
}
