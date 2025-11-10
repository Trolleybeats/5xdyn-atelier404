<?php

namespace App\Policies;

use App\Models\User;

class ImagePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function delete(User $user, $image)
    {
        // Seul l'auteur de l'image ou un administrateur peut la supprimer
        return $user->id === $image->user_id || $user->role === 'admin';
    }
}
