<?php

namespace App\Policies;

use App\Models\User;

class NotePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function delete(User $user, $note)
    {
        // Seul l'auteur de la note ou un administrateur peut la supprimer
        return $user->id === $note->user_id || $user->role === 'admin';
    }
}
