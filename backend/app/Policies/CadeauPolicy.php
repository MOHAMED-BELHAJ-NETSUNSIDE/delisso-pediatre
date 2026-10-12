<?php

namespace App\Policies;

use App\Models\Cadeau;
use App\Models\User;

class CadeauPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'gestionnaire'], true);
    }

    public function view(User $user, Cadeau $cadeau): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Cadeau $cadeau): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Cadeau $cadeau): bool
    {
        return $user->role === 'admin';
    }

    public function deleteAny(User $user): bool
    {
        return $user->role === 'admin';
    }
}
