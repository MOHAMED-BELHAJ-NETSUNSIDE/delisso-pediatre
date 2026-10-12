<?php
declare(strict_types=1);

namespace App\Auth;

use App\Config\Env;

final class JwtService
{
    public static function issue(array $user): string
    {
        $now = time();
        $ttl = (int) Env::get('JWT_TTL', '604800');
        $header = ['typ' => 'JWT', 'alg' => 'HS256'];
        $payload = [
            'iss' => Env::get('APP_URL', 'delisso'),
            'iat' => $now,
            'exp' => $now + $ttl,
            'sub' => (int) $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
        ];

        $segments = self::b64(json_encode($header, JSON_THROW_ON_ERROR))
            . '.' . self::b64(json_encode($payload, JSON_THROW_ON_ERROR));
        $signature = hash_hmac('sha256', $segments, self::secret(), true);
        return $segments . '.' . self::b64($signature);
    }

    public static function decode(string $token): ?array
    {
        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return null;
        }
        [$h64, $p64, $s64] = $parts;
        $expected = self::b64(hash_hmac('sha256', $h64 . '.' . $p64, self::secret(), true));
        if (!hash_equals($expected, $s64)) {
            return null;
        }
        $payload = json_decode(self::ub64($p64), true);
        if (!is_array($payload)) {
            return null;
        }
        if (($payload['exp'] ?? 0) < time()) {
            return null;
        }
        return $payload;
    }

    private static function secret(): string
    {
        return Env::get('JWT_SECRET', 'changeme') ?? 'changeme';
    }

    private static function b64(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private static function ub64(string $data): string
    {
        $remainder = strlen($data) % 4;
        if ($remainder) {
            $data .= str_repeat('=', 4 - $remainder);
        }
        return (string) base64_decode(strtr($data, '-_', '+/'), true);
    }
}
