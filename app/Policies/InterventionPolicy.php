<?php

namespace App\Policies;

use App\Models\Intervention;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InterventionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Seul l'administrateur peut voir la liste des interventions

        return $user->role === 'admin';
    }

    public function viewOwn(User $user): bool
    {
        if ($user->role === 'admin') {
            return true;
        }
        if ($user->role === 'technicien') {
            return true;
        }
        return false;
    }

    public function viewIndividual(User $user, Intervention $intervention): bool
    {
        if ($user->role === 'admin') {
            return true;
        }
        if ($user->role === 'technicien') {
             $derniere = $intervention->derniereAttribution;
             return $derniere && $user->id === $derniere->user_id;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Intervention $intervention): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        // Fallback to checking the latest attribution (there's no technicien_id on Intervention)
        $derniere = $intervention->derniereAttribution;
        return $derniere && $user->id === $derniere->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Intervention $intervention): bool
    {
        // Admin peut tout modifier
        if ($user->role === 'admin') {
            return true;
        }

        // Technicien peut modifier si c'est sa dernière attribution
        $derniereAttribution = $intervention->derniereAttribution;
        return $derniereAttribution && $derniereAttribution->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Intervention $intervention): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Intervention $intervention): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Intervention $intervention): bool
    {
        return false;
    }
}
