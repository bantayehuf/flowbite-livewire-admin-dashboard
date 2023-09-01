<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    private $parent = "users";

    /**
     * Determine whether the user can manage users.
     * Create, Update, Reset password, set role
     */
    public function manage(User $user): bool
    {
        return $user->can("manage_$this->parent");
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can("create_$this->parent");
    }


    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return $user->can("update_$this->parent");
    }


    /**
     * Determine whether the user can view models.
     * Also determines the permission type for all records or only for own records
     *
     */
    public function view(User $user) //: CanView | false
    {
        return $user->can("view_$this->parent");
    }
}
