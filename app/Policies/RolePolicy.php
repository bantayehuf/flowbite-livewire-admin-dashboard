<?php

namespace App\Policies;

use App\Models\User;

class RolePolicy
{
    private $parent = "roles";

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
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->can("delete_$this->parent");
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
