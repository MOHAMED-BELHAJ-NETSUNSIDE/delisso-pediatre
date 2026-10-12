<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Visite;

class VisitePolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'statistiques'], true);
    }

    public function view(User $user, Visite $visite): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Visite $visite): bool
    {
        return false;
    }

    public function delete(User $user, Visite $visite): bool
    {
        return false;
    }
}
