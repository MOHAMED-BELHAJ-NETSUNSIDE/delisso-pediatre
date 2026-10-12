<?php

namespace App\Services;

use App\Models\Cadeau;
use App\Models\StockMouvement;
use App\Models\User;
use App\Models\Visite;
use App\Models\VisiteCadeau;
use App\Models\VisitePhoto;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use RuntimeException;

class VisiteService
{
    /**
     * @param  array<string, mixed>  $data
     * @param  array<int, array{cadeau_id: int, qty: int}>  $lignes
     * @param  array<int, UploadedFile>  $photos
     */
    public function create(array $data, array $lignes, User $delegue, array $photos = []): Visite
    {
        if ($lignes === []) {
            throw new InvalidArgumentException('Au moins un cadeau est requis');
        }
        if (count($photos) > 5) {
            throw new InvalidArgumentException('Maximum 5 photos');
        }

        return DB::transaction(function () use ($data, $lignes, $delegue, $photos) {
            foreach ($lignes as $ligne) {
                $qty = (int) ($ligne['qty'] ?? 0);
                if ($qty <= 0) {
                    throw new InvalidArgumentException('Quantité invalide');
                }
                $cadeau = Cadeau::query()->whereKey((int) $ligne['cadeau_id'])->lockForUpdate()->first();
                if (! $cadeau || ! $cadeau->active) {
                    throw new RuntimeException('Cadeau indisponible');
                }
                if ($cadeau->stock < $qty) {
                    throw new RuntimeException('Stock insuffisant pour: '.$cadeau->name);
                }
            }

            $visite = Visite::query()->create([
                'medecin_id' => (int) $data['medecin_id'],
                'delegue_id' => $delegue->id,
                'nvisite' => (int) ($data['nvisite'] ?? 1),
                'classe' => $data['classe'] ?: null,
                'region' => $data['region'] ?? null,
                'municipalite' => $data['municipalite'] ?? null,
                'etab' => ($data['etab'] ?? '') !== '' && $data['etab'] !== null ? (int) $data['etab'] : null,
                'name_etab' => $data['name_etab'] ?? null,
                'gps' => $data['gps'] ?? null,
                'remarque' => $data['remarque'] ?? null,
            ]);

            foreach ($lignes as $ligne) {
                $cadeauId = (int) $ligne['cadeau_id'];
                $qty = (int) $ligne['qty'];

                Cadeau::query()->whereKey($cadeauId)->decrement('stock', $qty);
                VisiteCadeau::query()->create([
                    'visite_id' => $visite->id,
                    'cadeau_id' => $cadeauId,
                    'qty' => $qty,
                ]);
                StockMouvement::query()->create([
                    'cadeau_id' => $cadeauId,
                    'type' => 'out',
                    'qty' => $qty,
                    'user_id' => $delegue->id,
                    'visite_id' => $visite->id,
                    'note' => 'Remise visite #'.$visite->id,
                ]);
            }

            foreach (array_values($photos) as $order => $photo) {
                $path = $photo->store('visites/'.$visite->id, 'public');
                VisitePhoto::query()->create([
                    'visite_id' => $visite->id,
                    'path' => $path,
                    'sort_order' => $order,
                ]);
            }

            return $visite;
        });
    }
}
