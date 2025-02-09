<?php

namespace App\Policies;

use App\Models\AlbumAccessCode;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AlbumAccessCodePolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->is_admin;
    }

}
