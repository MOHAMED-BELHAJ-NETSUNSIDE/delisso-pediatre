<?php
declare(strict_types=1);

namespace App\Services;

use App\Database\Connection;
use PDO;

final class StockService
{
    public static function adjust(int $cadeauId, string $type, int $qty, int $userId, ?string $note = null): void
    {
        if (!in_array($type, ['in', 'out', 'adjust'], true)) {
            throw new \InvalidArgumentException('Type de mouvement invalide');
        }
        if ($qty <= 0 && $type !== 'adjust') {
            throw new \InvalidArgumentException('Quantité invalide');
        }

        $pdo = Connection::get();
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare('SELECT stock FROM cadeaux WHERE id = :id FOR UPDATE');
            $stmt->execute(['id' => $cadeauId]);
            $row = $stmt->fetch();
            if (!$row) {
                throw new \RuntimeException('Cadeau introuvable');
            }

            $stock = (int) $row['stock'];
            if ($type === 'in') {
                $stock += $qty;
            } elseif ($type === 'out') {
                if ($stock < $qty) {
                    throw new \RuntimeException('Stock insuffisant');
                }
                $stock -= $qty;
            } else {
                $stock = $qty;
            }

            $pdo->prepare('UPDATE cadeaux SET stock = :stock WHERE id = :id')->execute([
                'stock' => $stock,
                'id' => $cadeauId,
            ]);

            $pdo->prepare(
                'INSERT INTO stock_mouvements (cadeau_id, type, qty, user_id, note) VALUES (:c, :t, :q, :u, :n)'
            )->execute([
                'c' => $cadeauId,
                't' => $type,
                'q' => $qty,
                'u' => $userId,
                'n' => $note,
            ]);

            $pdo->commit();
        } catch (\Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }
    }
}
