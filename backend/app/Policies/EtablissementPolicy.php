<?php

namespace App\Policies;

use App\Models\Etablissement;
use App\Models\User;

class EtablissementPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function view(User $user, Etablissement $etablissement): bool
    {
        return $user->role === 'admin';
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Etablissement $etablissement): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Etablissement $etablissement): bool
    {
        return $user->role === 'admin';
    }

    public function deleteAny(User $user): bool
    {
        return $user->role === 'admin';
    }
}
