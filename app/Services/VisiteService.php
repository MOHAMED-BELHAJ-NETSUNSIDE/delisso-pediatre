<?php
declare(strict_types=1);

namespace App\Services;

use App\Database\Connection;
use App\Helpers\Upload;
use PDO;

final class VisiteService
{
    /**
     * @param array<int, array{cadeau_id:int, qty:int}> $lignes
     * @param array<int, array> $photos $_FILES entries
     */
    public static function create(array $data, array $lignes, int $delegueId, array $photos = []): int
    {
        if ($lignes === []) {
            throw new \InvalidArgumentException('Au moins un cadeau est requis');
        }
        if (count($photos) > 5) {
            throw new \InvalidArgumentException('Maximum 5 photos');
        }

        $pdo = Connection::get();
        $pdo->beginTransaction();
        try {
            foreach ($lignes as $ligne) {
                $cadeauId = (int) $ligne['cadeau_id'];
                $qty = (int) $ligne['qty'];
                if ($qty <= 0) {
                    throw new \InvalidArgumentException('Quantité invalide');
                }
                $stmt = $pdo->prepare('SELECT id, name, stock, active FROM cadeaux WHERE id = :id FOR UPDATE');
                $stmt->execute(['id' => $cadeauId]);
                $cadeau = $stmt->fetch();
                if (!$cadeau || !(int) $cadeau['active']) {
                    throw new \RuntimeException('Cadeau indisponible');
                }
                if ((int) $cadeau['stock'] < $qty) {
                    throw new \RuntimeException('Stock insuffisant pour: ' . $cadeau['name']);
                }
            }

            $stmt = $pdo->prepare(
                'INSERT INTO visites (medecin_id, delegue_id, nvisite, classe, region, municipalite, etab, name_etab, gps, remarque)
                 VALUES (:medecin_id, :delegue_id, :nvisite, :classe, :region, :municipalite, :etab, :name_etab, :gps, :remarque)'
            );
            $stmt->execute([
                'medecin_id' => (int) $data['medecin_id'],
                'delegue_id' => $delegueId,
                'nvisite' => (int) ($data['nvisite'] ?? 1),
                'classe' => $data['classe'] ?: null,
                'region' => $data['region'] ?? null,
                'municipalite' => $data['municipalite'] ?? null,
                'etab' => $data['etab'] !== '' && $data['etab'] !== null ? (int) $data['etab'] : null,
                'name_etab' => $data['name_etab'] ?? null,
                'gps' => $data['gps'] ?? null,
                'remarque' => $data['remarque'] ?? null,
            ]);
            $visiteId = (int) $pdo->lastInsertId();

            foreach ($lignes as $ligne) {
                $cadeauId = (int) $ligne['cadeau_id'];
                $qty = (int) $ligne['qty'];

                $pdo->prepare('UPDATE cadeaux SET stock = stock - :qty WHERE id = :id')->execute([
                    'qty' => $qty,
                    'id' => $cadeauId,
                ]);
                $pdo->prepare(
                    'INSERT INTO visite_cadeaux (visite_id, cadeau_id, qty) VALUES (:v, :c, :q)'
                )->execute(['v' => $visiteId, 'c' => $cadeauId, 'q' => $qty]);
                $pdo->prepare(
                    'INSERT INTO stock_mouvements (cadeau_id, type, qty, user_id, visite_id, note)
                     VALUES (:c, :t, :q, :u, :v, :n)'
                )->execute([
                    'c' => $cadeauId,
                    't' => 'out',
                    'q' => $qty,
                    'u' => $delegueId,
                    'v' => $visiteId,
                    'n' => 'Remise visite #' . $visiteId,
                ]);
            }

            $order = 0;
            foreach ($photos as $file) {
                if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
                    continue;
                }
                $path = Upload::saveImage($file, 'visites/' . $visiteId);
                $pdo->prepare(
                    'INSERT INTO visite_photos (visite_id, path, sort_order) VALUES (:v, :p, :o)'
                )->execute(['v' => $visiteId, 'p' => $path, 'o' => $order++]);
            }

            $pdo->commit();
            return $visiteId;
        } catch (\Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }
    }
}
