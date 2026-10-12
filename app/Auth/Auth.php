<?php
declare(strict_types=1);

namespace App\Auth;

use App\Database\Connection;
use PDO;

final class Auth
{
    public const ROLE_ADMIN = 'admin';
    public const ROLE_GESTIONNAIRE = 'gestionnaire';
    public const ROLE_STATISTIQUES = 'statistiques';
    public const ROLE_DELEGUE = 'delegue';

    public static function startSession(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function attempt(string $email, string $password): ?array
    {
        $pdo = Connection::get();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email AND active = 1 LIMIT 1');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();
        if (!$user || !password_verify($password, $user['password_hash'])) {
            return null;
        }
        unset($user['password_hash']);
        return $user;
    }

    public static function loginSession(array $user): void
    {
        self::startSession();
        $_SESSION['user'] = [
            'id' => (int) $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
        ];
    }

    public static function logout(): void
    {
        self::startSession();
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], (bool) $p['secure'], (bool) $p['httponly']);
        }
        session_destroy();
    }

    public static function user(): ?array
    {
        self::startSession();
        return $_SESSION['user'] ?? null;
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function hasRole(string ...$roles): bool
    {
        $user = self::user();
        if (!$user) {
            return false;
        }
        return in_array($user['role'], $roles, true);
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            header('Location: /admin/login');
            exit;
        }
        if (self::hasRole(self::ROLE_DELEGUE)) {
            self::logout();
            header('Location: /admin/login?error=role');
            exit;
        }
    }

    public static function requireRole(string ...$roles): void
    {
        self::requireLogin();
        if (!self::hasRole(...$roles)) {
            http_response_code(403);
            echo 'Accès refusé';
            exit;
        }
    }

    public static function findById(int $id): ?array
    {
        $pdo = Connection::get();
        $stmt = $pdo->prepare('SELECT id, name, email, role, active, created_at FROM users WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();
        return $user ?: null;
    }
}
