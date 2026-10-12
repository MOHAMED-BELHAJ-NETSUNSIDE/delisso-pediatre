<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

#[Fillable([
    'fullname',
    'type',
    'region',
    'municipalite',
    'etab',
    'name_etab',
    'adresse',
    'tel',
    'email',
    'classe',
    'active',
])]
class Medecin extends Model
{
    protected $table = 'medecins';

    protected function casts(): array
    {
        return [
            'type' => 'integer',
            'etab' => 'integer',
            'active' => 'boolean',
        ];
    }

    public function visites(): HasMany
    {
        return $this->hasMany(Visite::class);
    }

    /**
     * @param  Builder<Medecin>  $query
     */
    public function scopeSearch(Builder $query, string $term): void
    {
        $tokens = preg_split('/[\s\-]+/u', self::fold($term), -1, PREG_SPLIT_NO_EMPTY) ?: [];
        $applied = false;
        $rankToken = '';

        foreach ($tokens as $token) {
            $token = str_replace(['%', '_', '\\'], '', $token);
            if ($token === '') {
                continue;
            }

            $applied = true;
            if ($rankToken === '') {
                $rankToken = $token;
            }
            $like = '%'.$token.'%';
            $digits = preg_replace('/\D+/', '', $token) ?? '';

            $query->where(function (Builder $inner) use ($like, $digits) {
                foreach (['fullname', 'region', 'municipalite', 'name_etab', 'adresse', 'email', 'tel'] as $column) {
                    $inner->orWhereRaw(self::comparable($column).' LIKE ?', [$like]);
                }

                if (strlen($digits) >= 4) {
                    $inner->orWhereRaw(self::phoneSql('tel').' LIKE ?', ['%'.$digits.'%']);
                }
            });
        }

        if (! $applied) {
            $query->whereRaw('0 = 1');

            return;
        }

        $query->orderByRaw(
            'CASE WHEN '.self::comparable('fullname').' LIKE ? THEN 0 ELSE 1 END',
            [$rankToken.'%']
        )->orderBy('fullname');
    }

    private static function comparable(string $column): string
    {
        if (DB::connection()->getDriverName() === 'mysql') {
            return $column.' COLLATE utf8mb4_general_ci';
        }

        return self::foldedSql($column);
    }

    private static function fold(string $value): string
    {
        $value = mb_strtolower($value, 'UTF-8');

        return strtr($value, [
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ä' => 'a', 'ã' => 'a', 'å' => 'a',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
            'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'ö' => 'o', 'õ' => 'o',
            'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u',
            'ý' => 'y', 'ÿ' => 'y',
            'ç' => 'c', 'ñ' => 'n',
            'œ' => 'oe', 'æ' => 'ae',
        ]);
    }

    private static function foldedSql(string $column): string
    {
        $expr = $column;
        foreach ([
            'À' => 'a', 'Á' => 'a', 'Â' => 'a', 'Ä' => 'a', 'Ã' => 'a', 'Å' => 'a',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ä' => 'a', 'ã' => 'a', 'å' => 'a',
            'È' => 'e', 'É' => 'e', 'Ê' => 'e', 'Ë' => 'e',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
            'Ì' => 'i', 'Í' => 'i', 'Î' => 'i', 'Ï' => 'i',
            'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'Ò' => 'o', 'Ó' => 'o', 'Ô' => 'o', 'Ö' => 'o', 'Õ' => 'o',
            'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'ö' => 'o', 'õ' => 'o',
            'Ù' => 'u', 'Ú' => 'u', 'Û' => 'u', 'Ü' => 'u',
            'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u',
            'Ý' => 'y', 'Ÿ' => 'y', 'ý' => 'y', 'ÿ' => 'y',
            'Ç' => 'c', 'ç' => 'c', 'Ñ' => 'n', 'ñ' => 'n',
            'Œ' => 'oe', 'œ' => 'oe', 'Æ' => 'ae', 'æ' => 'ae',
        ] as $from => $to) {
            $expr = "REPLACE({$expr}, '{$from}', '{$to}')";
        }

        return "LOWER({$expr})";
    }

    private static function phoneSql(string $column): string
    {
        $expr = $column;
        foreach ([' ', '-', '.', '/', '(', ')', '+'] as $char) {
            $expr = "REPLACE({$expr}, '{$char}', '')";
        }

        return $expr;
    }
}
