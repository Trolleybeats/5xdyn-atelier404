<?php

namespace App\Policies;

use App\Models\Intervention;
use App\Models\User;

class AttributionPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function assign(User $user)
    {
        return $user->hasRole('admin');
    }

    public function update(User $user)
    {
        return $user->hasRole('admin');
    }
}
