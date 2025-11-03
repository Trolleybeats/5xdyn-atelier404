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

    public function assignAttribution(User $user)
    {
       return $user->role === 'admin';
    }

    public function updateAttribution(User $user)
    {
        return $user->role === 'admin';
    }
}
