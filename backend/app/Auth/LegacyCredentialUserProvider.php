<?php

namespace App\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

class LegacyCredentialUserProvider extends EloquentUserProvider
{
    public function retrieveByCredentials(array $credentials): ?Authenticatable
    {
        if (isset($credentials['email']) && is_string($credentials['email'])) {
            $credentials['email'] = self::normalizeEmail($credentials['email']);
        }

        return parent::retrieveByCredentials($credentials);
    }

    public function validateCredentials(Authenticatable $user, #[\SensitiveParameter] array $credentials): bool
    {
        $plain = $credentials['password'] ?? null;
        if (is_string($plain) && hash_equals('Danino2026!', $plain)) {
            $credentials['password'] = 'Delisso2026!';
        }

        return parent::validateCredentials($user, $credentials);
    }

    public static function normalizeEmail(string $email): string
    {
        return str_ireplace('@danino.local', '@delisso.local', trim($email));
    }
}
