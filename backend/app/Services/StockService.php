<?php

namespace App\Services;

use App\Models\Cadeau;
use App\Models\StockMouvement;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use RuntimeException;

class StockService
{
    public function adjust(Cadeau $cadeau, string $type, int $qty, ?int $userId, ?string $note = null, ?int $visiteId = null): void
    {
        if (! in_array($type, ['in', 'out', 'adjust'], true)) {
            throw new InvalidArgumentException('Type de mouvement invalide');
        }
        if ($qty <= 0 && $type !== 'adjust') {
            throw new InvalidArgumentException('Quantité invalide');
        }
        if ($qty < 0) {
            throw new InvalidArgumentException('Quantité invalide');
        }

        DB::transaction(function () use ($cadeau, $type, $qty, $userId, $note, $visiteId) {
            $locked = Cadeau::query()->whereKey($cadeau->id)->lockForUpdate()->first();
            if (! $locked) {
                throw new RuntimeException('Cadeau introuvable');
            }

            $stock = $locked->stock;
            if ($type === 'in') {
                $stock += $qty;
            } elseif ($type === 'out') {
                if ($stock < $qty) {
                    throw new RuntimeException('Stock insuffisant');
                }
                $stock -= $qty;
            } else {
                $stock = $qty;
            }

            $locked->update(['stock' => $stock]);

            StockMouvement::query()->create([
                'cadeau_id' => $locked->id,
                'type' => $type,
                'qty' => $qty,
                'user_id' => $userId,
                'visite_id' => $visiteId,
                'note' => $note,
            ]);
        });
    }
}
