<?php
declare(strict_types=1);

$root = dirname(__DIR__);
require $root . '/vendor/autoload.php';

use App\Auth\Auth;
use App\Config\Env;
use App\Database\Connection;
use App\Helpers\Response;
use App\Helpers\Upload;
use App\Helpers\View;
use App\Services\DashboardService;
use App\Services\StockService;
use App\Services\VisiteService;

Env::load($root);

$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$uri = rtrim($uri, '/') ?: '/';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// ---------- API ----------
if (str_starts_with($uri, '/api')) {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Authorization, Content-Type');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    if ($method === 'OPTIONS') {
        http_response_code(204);
        exit;
    }

    try {
        require $root . '/api/routes.php';
    } catch (Throwable $e) {
        $debug = Env::get('APP_DEBUG', 'false') === 'true';
        Response::error($debug ? $e->getMessage() : 'Erreur serveur', 500);
    }
    exit;
}

// ---------- Admin ----------
Auth::startSession();

try {
    match (true) {
        $uri === '/' => redirect('/admin'),
        $uri === '/admin' || $uri === '/admin/dashboard' => adminDashboard(),
        $uri === '/admin/login' && $method === 'GET' => adminLoginForm(),
        $uri === '/admin/login' && $method === 'POST' => adminLoginPost(),
        $uri === '/admin/logout' => adminLogout(),

        $uri === '/admin/medecins' => adminMedecins(),
        $uri === '/admin/medecins/create' && $method === 'GET' => adminMedecinForm(),
        $uri === '/admin/medecins/create' && $method === 'POST' => adminMedecinSave(),
        preg_match('#^/admin/medecins/(\d+)/edit$#', $uri, $m) === 1 && $method === 'GET' => adminMedecinForm((int) $m[1]),
        preg_match('#^/admin/medecins/(\d+)/edit$#', $uri, $m) === 1 && $method === 'POST' => adminMedecinSave((int) $m[1]),

        $uri === '/admin/cadeaux' => adminCadeaux(),
        $uri === '/admin/cadeaux/create' && $method === 'GET' => adminCadeauForm(),
        $uri === '/admin/cadeaux/create' && $method === 'POST' => adminCadeauSave(),
        preg_match('#^/admin/cadeaux/(\d+)/edit$#', $uri, $m) === 1 && $method === 'GET' => adminCadeauForm((int) $m[1]),
        preg_match('#^/admin/cadeaux/(\d+)/edit$#', $uri, $m) === 1 && $method === 'POST' => adminCadeauSave((int) $m[1]),
        preg_match('#^/admin/cadeaux/(\d+)/stock$#', $uri, $m) === 1 && $method === 'POST' => adminCadeauStock((int) $m[1]),

        $uri === '/admin/visites' => adminVisites(),
        preg_match('#^/admin/visites/(\d+)$#', $uri, $m) === 1 => adminVisiteShow((int) $m[1]),

        $uri === '/admin/users' => adminUsers(),
        $uri === '/admin/users/create' && $method === 'GET' => adminUserForm(),
        $uri === '/admin/users/create' && $method === 'POST' => adminUserSave(),
        preg_match('#^/admin/users/(\d+)/edit$#', $uri, $m) === 1 && $method === 'GET' => adminUserForm((int) $m[1]),
        preg_match('#^/admin/users/(\d+)/edit$#', $uri, $m) === 1 && $method === 'POST' => adminUserSave((int) $m[1]),

        $uri === '/admin/etablissements' => adminEtabs(),
        $uri === '/admin/etablissements/create' && $method === 'POST' => adminEtabCreate(),

        default => notFound(),
    };
} catch (Throwable $e) {
    $debug = Env::get('APP_DEBUG', 'false') === 'true';
    http_response_code(500);
    echo $debug ? View::e($e->getMessage()) : 'Erreur serveur';
}

function redirect(string $to): never
{
    header('Location: ' . $to);
    exit;
}

function notFound(): void
{
    http_response_code(404);
    echo 'Page introuvable';
}

function flash(string $type, string $msg): void
{
    $_SESSION['flash'] = ['type' => $type, 'msg' => $msg];
}

function takeFlash(): ?array
{
    $f = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $f;
}

function adminLoginForm(): void
{
    if (Auth::check() && !Auth::hasRole(Auth::ROLE_DELEGUE)) {
        redirect('/admin/dashboard');
    }
    View::render('auth/login', [
        'error' => $_GET['error'] ?? null,
        'flash' => takeFlash(),
    ], '');
}

function adminLoginPost(): void
{
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $user = Auth::attempt($email, $password);
    if (!$user) {
        flash('err', 'Identifiants invalides');
        redirect('/admin/login');
    }
    if ($user['role'] === Auth::ROLE_DELEGUE) {
        flash('err', 'Les délégués utilisent l’application mobile');
        redirect('/admin/login');
    }
    Auth::loginSession($user);
    redirect('/admin/dashboard');
}

function adminLogout(): void
{
    Auth::logout();
    redirect('/admin/login');
}

function adminDashboard(): void
{
    Auth::requireRole(Auth::ROLE_ADMIN, Auth::ROLE_STATISTIQUES, Auth::ROLE_GESTIONNAIRE);
    $from = $_GET['from'] ?? null;
    $to = $_GET['to'] ?? null;
    $stats = DashboardService::stats($from, $to);
    View::render('dashboard/index', [
        'stats' => $stats,
        'flash' => takeFlash(),
        'page' => 'dashboard',
    ]);
}

function adminMedecins(): void
{
    Auth::requireRole(Auth::ROLE_ADMIN);
    $pdo = Connection::get();
    $q = trim($_GET['q'] ?? '');
    if ($q !== '') {
        $stmt = $pdo->prepare('SELECT * FROM medecins WHERE fullname LIKE :q ORDER BY fullname');
        $stmt->execute(['q' => '%' . $q . '%']);
        $rows = $stmt->fetchAll();
    } else {
        $rows = $pdo->query('SELECT * FROM medecins ORDER BY fullname')->fetchAll();
    }
    View::render('medecins/index', ['rows' => $rows, 'q' => $q, 'flash' => takeFlash(), 'page' => 'medecins']);
}

function adminMedecinForm(?int $id = null): void
{
    Auth::requireRole(Auth::ROLE_ADMIN);
    $pdo = Connection::get();
    $row = null;
    if ($id) {
        $stmt = $pdo->prepare('SELECT * FROM medecins WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch() ?: null;
    }
    $etabs = $pdo->query('SELECT * FROM etablissements ORDER BY name')->fetchAll();
    View::render('medecins/form', ['row' => $row, 'etabs' => $etabs, 'page' => 'medecins']);
}

function adminMedecinSave(?int $id = null): void
{
    Auth::requireRole(Auth::ROLE_ADMIN);
    $pdo = Connection::get();
    $data = [
        'fullname' => trim($_POST['fullname'] ?? ''),
        'type' => (int) ($_POST['type'] ?? 1),
        'region' => trim($_POST['region'] ?? ''),
        'municipalite' => trim($_POST['municipalite'] ?? ''),
        'etab' => $_POST['etab'] !== '' ? (int) $_POST['etab'] : null,
        'name_etab' => trim($_POST['name_etab'] ?? ''),
        'adresse' => trim($_POST['adresse'] ?? ''),
        'tel' => trim($_POST['tel'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'classe' => $_POST['classe'] !== '' ? $_POST['classe'] : null,
        'active' => isset($_POST['active']) ? 1 : 0,
    ];
    if ($data['fullname'] === '') {
        flash('err', 'Nom obligatoire');
        redirect($id ? "/admin/medecins/{$id}/edit" : '/admin/medecins/create');
    }
    if ($id) {
        $sql = 'UPDATE medecins SET fullname=:fullname, type=:type, region=:region, municipalite=:municipalite, etab=:etab, name_etab=:name_etab, adresse=:adresse, tel=:tel, email=:email, classe=:classe, active=:active WHERE id=:id';
        $data['id'] = $id;
        $pdo->prepare($sql)->execute($data);
        flash('ok', 'Médecin mis à jour');
    } else {
        $sql = 'INSERT INTO medecins (fullname,type,region,municipalite,etab,name_etab,adresse,tel,email,classe,active) VALUES (:fullname,:type,:region,:municipalite,:etab,:name_etab,:adresse,:tel,:email,:classe,:active)';
        $pdo->prepare($sql)->execute($data);
        flash('ok', 'Médecin créé');
    }
    redirect('/admin/medecins');
}

function adminCadeaux(): void
{
    Auth::requireRole(Auth::ROLE_ADMIN, Auth::ROLE_GESTIONNAIRE);
    $rows = Connection::get()->query('SELECT * FROM cadeaux ORDER BY name')->fetchAll();
    View::render('cadeaux/index', [
        'rows' => $rows,
        'flash' => takeFlash(),
        'page' => 'cadeaux',
        'canEdit' => Auth::hasRole(Auth::ROLE_ADMIN),
        'canStock' => Auth::hasRole(Auth::ROLE_ADMIN, Auth::ROLE_GESTIONNAIRE),
    ]);
}

function adminCadeauForm(?int $id = null): void
{
    Auth::requireRole(Auth::ROLE_ADMIN);
    $row = null;
    if ($id) {
        $stmt = Connection::get()->prepare('SELECT * FROM cadeaux WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch() ?: null;
    }
    View::render('cadeaux/form', ['row' => $row, 'page' => 'cadeaux']);
}

function adminCadeauSave(?int $id = null): void
{
    Auth::requireRole(Auth::ROLE_ADMIN);
    $pdo = Connection::get();
    $name = trim($_POST['name'] ?? '');
    $seuil = (int) ($_POST['seuil_alerte'] ?? 10);
    $active = isset($_POST['active']) ? 1 : 0;
    $imagePath = null;

    if (!empty($_FILES['image']['name'])) {
        $imagePath = Upload::saveImage($_FILES['image'], 'cadeaux');
    }

    if ($name === '') {
        flash('err', 'Nom obligatoire');
        redirect($id ? "/admin/cadeaux/{$id}/edit" : '/admin/cadeaux/create');
    }

    if ($id) {
        if ($imagePath) {
            $pdo->prepare('UPDATE cadeaux SET name=:n, seuil_alerte=:s, active=:a, image_path=:i WHERE id=:id')
                ->execute(['n' => $name, 's' => $seuil, 'a' => $active, 'i' => $imagePath, 'id' => $id]);
        } else {
            $pdo->prepare('UPDATE cadeaux SET name=:n, seuil_alerte=:s, active=:a WHERE id=:id')
                ->execute(['n' => $name, 's' => $seuil, 'a' => $active, 'id' => $id]);
        }
        flash('ok', 'Cadeau mis à jour');
    } else {
        $stock = (int) ($_POST['stock'] ?? 0);
        $pdo->prepare('INSERT INTO cadeaux (name, image_path, stock, seuil_alerte, active) VALUES (:n,:i,:st,:s,:a)')
            ->execute(['n' => $name, 'i' => $imagePath, 'st' => $stock, 's' => $seuil, 'a' => $active]);
        flash('ok', 'Cadeau créé');
    }
    redirect('/admin/cadeaux');
}

function adminCadeauStock(int $id): void
{
    Auth::requireRole(Auth::ROLE_ADMIN, Auth::ROLE_GESTIONNAIRE);
    $type = $_POST['type'] ?? 'in';
    $qty = (int) ($_POST['qty'] ?? 0);
    $note = trim($_POST['note'] ?? '');
    try {
        StockService::adjust($id, $type, $qty, (int) Auth::user()['id'], $note ?: null);
        flash('ok', 'Stock mis à jour');
    } catch (Throwable $e) {
        flash('err', $e->getMessage());
    }
    redirect('/admin/cadeaux');
}

function adminVisites(): void
{
    Auth::requireRole(Auth::ROLE_ADMIN, Auth::ROLE_STATISTIQUES);
    $pdo = Connection::get();
    $sql = 'SELECT v.*, m.fullname AS medecin_name, u.name AS delegue_name
            FROM visites v
            JOIN medecins m ON m.id = v.medecin_id
            JOIN users u ON u.id = v.delegue_id
            WHERE 1=1';
    $params = [];
    if (!empty($_GET['from'])) {
        $sql .= ' AND DATE(v.created_at) >= :from';
        $params['from'] = $_GET['from'];
    }
    if (!empty($_GET['to'])) {
        $sql .= ' AND DATE(v.created_at) <= :to';
        $params['to'] = $_GET['to'];
    }
    $sql .= ' ORDER BY v.created_at DESC LIMIT 200';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    View::render('visites/index', [
        'rows' => $stmt->fetchAll(),
        'filters' => $_GET,
        'page' => 'visites',
        'flash' => takeFlash(),
    ]);
}

function adminVisiteShow(int $id): void
{
    Auth::requireRole(Auth::ROLE_ADMIN, Auth::ROLE_STATISTIQUES);
    $pdo = Connection::get();
    $stmt = $pdo->prepare(
        'SELECT v.*, m.fullname AS medecin_name, u.name AS delegue_name
         FROM visites v
         JOIN medecins m ON m.id = v.medecin_id
         JOIN users u ON u.id = v.delegue_id
         WHERE v.id = :id'
    );
    $stmt->execute(['id' => $id]);
    $visite = $stmt->fetch();
    if (!$visite) {
        notFound();
        return;
    }
    $cadeaux = $pdo->prepare(
        'SELECT c.name, vc.qty FROM visite_cadeaux vc JOIN cadeaux c ON c.id = vc.cadeau_id WHERE vc.visite_id = :id'
    );
    $cadeaux->execute(['id' => $id]);
    $photos = $pdo->prepare('SELECT * FROM visite_photos WHERE visite_id = :id ORDER BY sort_order');
    $photos->execute(['id' => $id]);
    View::render('visites/show', [
        'visite' => $visite,
        'cadeaux' => $cadeaux->fetchAll(),
        'photos' => $photos->fetchAll(),
        'page' => 'visites',
    ]);
}

function adminUsers(): void
{
    Auth::requireRole(Auth::ROLE_ADMIN);
    $rows = Connection::get()->query('SELECT id, name, email, role, active, created_at FROM users ORDER BY name')->fetchAll();
    View::render('users/index', ['rows' => $rows, 'flash' => takeFlash(), 'page' => 'users']);
}

function adminUserForm(?int $id = null): void
{
    Auth::requireRole(Auth::ROLE_ADMIN);
    $row = null;
    if ($id) {
        $row = Auth::findById($id);
    }
    View::render('users/form', ['row' => $row, 'page' => 'users']);
}

function adminUserSave(?int $id = null): void
{
    Auth::requireRole(Auth::ROLE_ADMIN);
    $pdo = Connection::get();
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = $_POST['role'] ?? 'delegue';
    $active = isset($_POST['active']) ? 1 : 0;
    $password = $_POST['password'] ?? '';

    if ($name === '' || $email === '' || !in_array($role, ['admin', 'gestionnaire', 'statistiques', 'delegue'], true)) {
        flash('err', 'Données invalides');
        redirect($id ? "/admin/users/{$id}/edit" : '/admin/users/create');
    }

    if ($id) {
        if ($password !== '') {
            $pdo->prepare('UPDATE users SET name=:n, email=:e, role=:r, active=:a, password_hash=:p WHERE id=:id')
                ->execute(['n' => $name, 'e' => $email, 'r' => $role, 'a' => $active, 'p' => password_hash($password, PASSWORD_DEFAULT), 'id' => $id]);
        } else {
            $pdo->prepare('UPDATE users SET name=:n, email=:e, role=:r, active=:a WHERE id=:id')
                ->execute(['n' => $name, 'e' => $email, 'r' => $role, 'a' => $active, 'id' => $id]);
        }
        flash('ok', 'Utilisateur mis à jour');
    } else {
        if ($password === '') {
            flash('err', 'Mot de passe obligatoire');
            redirect('/admin/users/create');
        }
        $pdo->prepare('INSERT INTO users (name, email, password_hash, role, active) VALUES (:n,:e,:p,:r,:a)')
            ->execute(['n' => $name, 'e' => $email, 'p' => password_hash($password, PASSWORD_DEFAULT), 'r' => $role, 'a' => $active]);
        flash('ok', 'Utilisateur créé');
    }
    redirect('/admin/users');
}

function adminEtabs(): void
{
    Auth::requireRole(Auth::ROLE_ADMIN);
    $rows = Connection::get()->query('SELECT * FROM etablissements ORDER BY name')->fetchAll();
    View::render('etablissements/index', ['rows' => $rows, 'flash' => takeFlash(), 'page' => 'etablissements']);
}

function adminEtabCreate(): void
{
    Auth::requireRole(Auth::ROLE_ADMIN);
    $name = trim($_POST['name'] ?? '');
    if ($name !== '') {
        Connection::get()->prepare('INSERT INTO etablissements (name) VALUES (:n)')->execute(['n' => $name]);
        flash('ok', 'Établissement ajouté');
    }
    redirect('/admin/etablissements');
}
