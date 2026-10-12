<?php

namespace App\Policies;

use App\Models\Medecin;
use App\Models\User;

class MedecinPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function view(User $user, Medecin $medecin): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Medecin $medecin): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Medecin $medecin): bool
    {
        return $user->role === 'admin';
    }

    public function deleteAny(User $user): bool
    {
        return $user->role === 'admin';
    }
}
