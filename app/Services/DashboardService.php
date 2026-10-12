<?php
declare(strict_types=1);

namespace App\Services;

use App\Database\Connection;
use PDO;

final class DashboardService
{
    public static function stats(?string $from = null, ?string $to = null): array
    {
        $pdo = Connection::get();
        $from = $from ?: date('Y-m-01');
        $to = $to ?: date('Y-m-d');

        $visites = $pdo->prepare('SELECT COUNT(*) FROM visites WHERE DATE(created_at) BETWEEN :f AND :t');
        $visites->execute(['f' => $from, 't' => $to]);
        $visitesCount = (int) $visites->fetchColumn();

        $today = (int) $pdo->query('SELECT COUNT(*) FROM visites WHERE DATE(created_at) = CURDATE()')->fetchColumn();

        $lowStock = $pdo->query('SELECT id, name, stock, seuil_alerte FROM cadeaux WHERE active = 1 AND stock <= seuil_alerte ORDER BY stock ASC')->fetchAll();

        $top = $pdo->prepare(
            'SELECT c.name, SUM(vc.qty) AS total
             FROM visite_cadeaux vc
             JOIN cadeaux c ON c.id = vc.cadeau_id
             JOIN visites v ON v.id = vc.visite_id
             WHERE DATE(v.created_at) BETWEEN :f AND :t
             GROUP BY c.id, c.name
             ORDER BY total DESC
             LIMIT 10'
        );
        $top->execute(['f' => $from, 't' => $to]);

        return [
            'from' => $from,
            'to' => $to,
            'visites_periode' => $visitesCount,
            'visites_jour' => $today,
            'stock_bas' => $lowStock,
            'top_cadeaux' => $top->fetchAll(),
        ];
    }
}
