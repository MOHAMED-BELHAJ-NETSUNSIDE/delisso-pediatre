<?php
declare(strict_types=1);

use App\Auth\Auth;
use App\Auth\JwtService;
use App\Database\Connection;
use App\Helpers\Response;
use App\Services\VisiteService;

$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$uri = rtrim($uri, '/') ?: '/';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

function apiUser(): array
{
    $header = $_SERVER['HTTP_AUTHORIZATION'] ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? '';
    if (!preg_match('/Bearer\s+(\S+)/i', $header, $m)) {
        Response::error('Token manquant', 401);
    }
    $payload = JwtService::decode($m[1]);
    if (!$payload || empty($payload['sub'])) {
        Response::error('Token invalide', 401);
    }
    $user = Auth::findById((int) $payload['sub']);
    if (!$user || !(int) $user['active']) {
        Response::error('Utilisateur inactif', 401);
    }
    return $user;
}

function requireApiRole(array $user, string ...$roles): void
{
    if (!in_array($user['role'], $roles, true)) {
        Response::error('Accès refusé', 403);
    }
}

function jsonBody(): array
{
    $raw = file_get_contents('php://input') ?: '';
    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

if ($uri === '/api/auth/login' && $method === 'POST') {
    $data = jsonBody();
    $user = Auth::attempt(trim((string) ($data['email'] ?? '')), (string) ($data['password'] ?? ''));
    if (!$user) {
        Response::error('Identifiants invalides', 401);
    }
    Response::json([
        'token' => JwtService::issue($user),
        'user' => [
            'id' => (int) $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
        ],
    ]);
}

if ($uri === '/api/auth/me' && $method === 'GET') {
    $user = apiUser();
    Response::json(['user' => $user]);
}

if ($uri === '/api/medecins' && $method === 'GET') {
    $user = apiUser();
    $pdo = Connection::get();
    $q = trim($_GET['q'] ?? '');
    $isAdmin = in_array($user['role'], [Auth::ROLE_ADMIN], true);
    $activeFilter = $isAdmin ? '' : ' AND active = 1';
    if ($q !== '') {
        $stmt = $pdo->prepare("SELECT * FROM medecins WHERE fullname LIKE :q{$activeFilter} ORDER BY fullname LIMIT 200");
        $stmt->execute(['q' => '%' . $q . '%']);
        Response::json(['data' => $stmt->fetchAll()]);
    }
    $rows = $pdo->query("SELECT * FROM medecins WHERE 1=1{$activeFilter} ORDER BY fullname LIMIT 500")->fetchAll();
    Response::json(['data' => $rows]);
}

if (preg_match('#^/api/medecins/(\d+)$#', $uri, $m) && $method === 'GET') {
    $user = apiUser();
    $stmt = Connection::get()->prepare('SELECT * FROM medecins WHERE id = :id');
    $stmt->execute(['id' => (int) $m[1]]);
    $row = $stmt->fetch();
    if (!$row) {
        Response::error('Médecin introuvable', 404);
    }
    Response::json(['data' => $row]);
}

if (preg_match('#^/api/medecins/(\d+)$#', $uri, $m) && $method === 'PUT') {
    $user = apiUser();
    requireApiRole($user, Auth::ROLE_ADMIN);
    $data = jsonBody();
    $pdo = Connection::get();
    $id = (int) $m[1];
    $pdo->prepare(
        'UPDATE medecins SET fullname=:fullname,type=:type,region=:region,municipalite=:municipalite,etab=:etab,name_etab=:name_etab,adresse=:adresse,tel=:tel,email=:email,classe=:classe,active=:active WHERE id=:id'
    )->execute([
        'fullname' => trim((string) ($data['fullname'] ?? '')),
        'type' => (int) ($data['type'] ?? 1),
        'region' => $data['region'] ?? null,
        'municipalite' => $data['municipalite'] ?? null,
        'etab' => isset($data['etab']) && $data['etab'] !== '' ? (int) $data['etab'] : null,
        'name_etab' => $data['name_etab'] ?? null,
        'adresse' => $data['adresse'] ?? null,
        'tel' => $data['tel'] ?? null,
        'email' => $data['email'] ?? null,
        'classe' => $data['classe'] ?: null,
        'active' => isset($data['active']) ? (int) $data['active'] : 1,
        'id' => $id,
    ]);
    Response::json(['ok' => true]);
}

if ($uri === '/api/medecins' && $method === 'POST') {
    $user = apiUser();
    $data = jsonBody();
    $fullname = trim((string) ($data['fullname'] ?? ''));
    if ($fullname === '') {
        Response::error('fullname requis');
    }
    $pdo = Connection::get();
    $pdo->prepare(
        'INSERT INTO medecins (fullname, type, region, municipalite, etab, name_etab, adresse, tel, email, classe, active)
         VALUES (:fullname,:type,:region,:municipalite,:etab,:name_etab,:adresse,:tel,:email,:classe,1)'
    )->execute([
        'fullname' => $fullname,
        'type' => (int) ($data['type'] ?? 1),
        'region' => $data['region'] ?? null,
        'municipalite' => $data['municipalite'] ?? null,
        'etab' => isset($data['etab']) ? (int) $data['etab'] : null,
        'name_etab' => $data['name_etab'] ?? null,
        'adresse' => $data['adresse'] ?? null,
        'tel' => $data['tel'] ?? null,
        'email' => $data['email'] ?? null,
        'classe' => $data['classe'] ?? null,
    ]);
    Response::json(['id' => (int) $pdo->lastInsertId()], 201);
}

if ($uri === '/api/cadeaux' && $method === 'GET') {
    $user = apiUser();
    $isAdmin = in_array($user['role'], [Auth::ROLE_ADMIN, Auth::ROLE_GESTIONNAIRE], true);
    if ($isAdmin) {
        $rows = Connection::get()->query('SELECT * FROM cadeaux ORDER BY name')->fetchAll();
    } else {
        $rows = Connection::get()->query('SELECT id, name, image_path, stock, seuil_alerte FROM cadeaux WHERE active = 1 ORDER BY name')->fetchAll();
    }
    Response::json(['data' => $rows]);
}

if ($uri === '/api/cadeaux' && $method === 'POST') {
    $user = apiUser();
    requireApiRole($user, Auth::ROLE_ADMIN);
    $data = jsonBody();
    $pdo = Connection::get();
    $pdo->prepare('INSERT INTO cadeaux (name,stock,seuil_alerte,active) VALUES (:n,:s,:sa,:a)')
        ->execute(['n' => trim($data['name'] ?? ''), 's' => (int)($data['stock'] ?? 0), 'sa' => (int)($data['seuil_alerte'] ?? 10), 'a' => (int)($data['active'] ?? 1)]);
    Response::json(['id' => (int) $pdo->lastInsertId()], 201);
}

if (preg_match('#^/api/cadeaux/(\d+)$#', $uri, $m) && $method === 'PUT') {
    $user = apiUser();
    requireApiRole($user, Auth::ROLE_ADMIN);
    $data = jsonBody();
    Connection::get()->prepare('UPDATE cadeaux SET name=:n,seuil_alerte=:sa,active=:a WHERE id=:id')
        ->execute(['n' => trim($data['name'] ?? ''), 'sa' => (int)($data['seuil_alerte'] ?? 10), 'a' => (int)($data['active'] ?? 1), 'id' => (int)$m[1]]);
    Response::json(['ok' => true]);
}

if (preg_match('#^/api/cadeaux/(\d+)/stock$#', $uri, $m) && $method === 'POST') {
    $user = apiUser();
    requireApiRole($user, Auth::ROLE_ADMIN, Auth::ROLE_GESTIONNAIRE);
    $data = jsonBody();
    try {
        StockService::adjust((int)$m[1], $data['type'] ?? 'in', (int)($data['qty'] ?? 0), (int)$user['id'], $data['note'] ?? null);
        Response::json(['ok' => true]);
    } catch (Throwable $e) {
        Response::error($e->getMessage(), 422);
    }
}

if ($uri === '/api/etablissements' && $method === 'GET') {
    $user = apiUser();
    $rows = Connection::get()->query('SELECT id, name FROM etablissements ORDER BY name')->fetchAll();
    Response::json(['data' => $rows]);
}

if ($uri === '/api/etablissements' && $method === 'POST') {
    $user = apiUser();
    requireApiRole($user, Auth::ROLE_ADMIN);
    $data = jsonBody();
    $name = trim($data['name'] ?? '');
    if ($name === '') Response::error('Nom requis');
    Connection::get()->prepare('INSERT INTO etablissements (name) VALUES (:n)')->execute(['n' => $name]);
    Response::json(['ok' => true], 201);
}

if ($uri === '/api/users' && $method === 'GET') {
    $user = apiUser();
    requireApiRole($user, Auth::ROLE_ADMIN);
    $rows = Connection::get()->query('SELECT id, name, email, role, active, created_at FROM users ORDER BY name')->fetchAll();
    Response::json(['data' => $rows]);
}

if ($uri === '/api/users' && $method === 'POST') {
    $user = apiUser();
    requireApiRole($user, Auth::ROLE_ADMIN);
    $data = jsonBody();
    $pdo = Connection::get();
    $pdo->prepare('INSERT INTO users (name,email,password_hash,role,active) VALUES (:n,:e,:p,:r,:a)')
        ->execute(['n' => trim($data['name'] ?? ''), 'e' => trim($data['email'] ?? ''), 'p' => password_hash($data['password'] ?? '', PASSWORD_DEFAULT), 'r' => $data['role'] ?? 'delegue', 'a' => (int)($data['active'] ?? 1)]);
    Response::json(['id' => (int) $pdo->lastInsertId()], 201);
}

if (preg_match('#^/api/users/(\d+)$#', $uri, $m) && $method === 'PUT') {
    $user = apiUser();
    requireApiRole($user, Auth::ROLE_ADMIN);
    $data = jsonBody();
    $pdo = Connection::get();
    if (!empty($data['password'])) {
        $pdo->prepare('UPDATE users SET name=:n,email=:e,role=:r,active=:a,password_hash=:p WHERE id=:id')
            ->execute(['n' => trim($data['name'] ?? ''), 'e' => trim($data['email'] ?? ''), 'r' => $data['role'] ?? 'delegue', 'a' => (int)($data['active'] ?? 1), 'p' => password_hash($data['password'], PASSWORD_DEFAULT), 'id' => (int)$m[1]]);
    } else {
        $pdo->prepare('UPDATE users SET name=:n,email=:e,role=:r,active=:a WHERE id=:id')
            ->execute(['n' => trim($data['name'] ?? ''), 'e' => trim($data['email'] ?? ''), 'r' => $data['role'] ?? 'delegue', 'a' => (int)($data['active'] ?? 1), 'id' => (int)$m[1]]);
    }
    Response::json(['ok' => true]);
}

if ($uri === '/api/visites' && $method === 'GET') {
    $user = apiUser();
    requireApiRole($user, Auth::ROLE_ADMIN, Auth::ROLE_STATISTIQUES);
    $pdo = Connection::get();
    $sql = 'SELECT v.*, m.fullname AS medecin_name, u.name AS delegue_name FROM visites v JOIN medecins m ON m.id = v.medecin_id JOIN users u ON u.id = v.delegue_id WHERE 1=1';
    $params = [];
    if (!empty($_GET['from'])) { $sql .= ' AND DATE(v.created_at) >= :from'; $params['from'] = $_GET['from']; }
    if (!empty($_GET['to'])) { $sql .= ' AND DATE(v.created_at) <= :to'; $params['to'] = $_GET['to']; }
    $sql .= ' ORDER BY v.created_at DESC LIMIT 200';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    Response::json(['data' => $stmt->fetchAll()]);
}

if (preg_match('#^/api/visites/(\d+)$#', $uri, $m) && $method === 'GET') {
    $user = apiUser();
    requireApiRole($user, Auth::ROLE_ADMIN, Auth::ROLE_STATISTIQUES);
    $pdo = Connection::get();
    $id = (int)$m[1];
    $stmt = $pdo->prepare('SELECT v.*, m.fullname AS medecin_name, u.name AS delegue_name FROM visites v JOIN medecins m ON m.id = v.medecin_id JOIN users u ON u.id = v.delegue_id WHERE v.id = :id');
    $stmt->execute(['id' => $id]);
    $visite = $stmt->fetch();
    if (!$visite) Response::error('Visite introuvable', 404);
    $cadeaux = $pdo->prepare('SELECT c.name, vc.qty FROM visite_cadeaux vc JOIN cadeaux c ON c.id = vc.cadeau_id WHERE vc.visite_id = :id');
    $cadeaux->execute(['id' => $id]);
    $photos = $pdo->prepare('SELECT * FROM visite_photos WHERE visite_id = :id ORDER BY sort_order');
    $photos->execute(['id' => $id]);
    Response::json(['data' => array_merge($visite, ['cadeaux' => $cadeaux->fetchAll(), 'photos' => $photos->fetchAll()])]);
}

if ($uri === '/api/dashboard/stats' && $method === 'GET') {
    $user = apiUser();
    requireApiRole($user, Auth::ROLE_ADMIN, Auth::ROLE_STATISTIQUES, Auth::ROLE_GESTIONNAIRE);
    $from = $_GET['from'] ?? null;
    $to = $_GET['to'] ?? null;
    Response::json(['data' => DashboardService::stats($from, $to)]);
}

if ($uri === '/api/visites/me' && $method === 'GET') {
    $user = apiUser();
    requireApiRole($user, Auth::ROLE_DELEGUE);
    $stmt = Connection::get()->prepare(
        'SELECT v.*, m.fullname AS medecin_name
         FROM visites v JOIN medecins m ON m.id = v.medecin_id
         WHERE v.delegue_id = :id
         ORDER BY v.created_at DESC LIMIT 50'
    );
    $stmt->execute(['id' => (int) $user['id']]);
    Response::json(['data' => $stmt->fetchAll()]);
}

if ($uri === '/api/visites' && $method === 'POST') {
    $user = apiUser();
    requireApiRole($user, Auth::ROLE_DELEGUE);

    $payload = $_POST;
    if (empty($payload) || empty($payload['medecin_id'])) {
        $payload = jsonBody();
    }

    $lignesRaw = $payload['cadeaux'] ?? '[]';
    if (is_string($lignesRaw)) {
        $lignes = json_decode($lignesRaw, true) ?: [];
    } else {
        $lignes = is_array($lignesRaw) ? $lignesRaw : [];
    }

    $photos = [];
    if (!empty($_FILES['photos'])) {
        $files = $_FILES['photos'];
        if (is_array($files['name'])) {
            foreach ($files['name'] as $i => $name) {
                if ($name === '') {
                    continue;
                }
                $photos[] = [
                    'name' => $files['name'][$i],
                    'type' => $files['type'][$i],
                    'tmp_name' => $files['tmp_name'][$i],
                    'error' => $files['error'][$i],
                    'size' => $files['size'][$i],
                ];
            }
        }
    }

    try {
        $id = VisiteService::create($payload, $lignes, (int) $user['id'], $photos);
        Response::json(['id' => $id, 'message' => 'Visite enregistrée'], 201);
    } catch (Throwable $e) {
        Response::error($e->getMessage(), 422);
    }
}

Response::error('Route API introuvable', 404);
