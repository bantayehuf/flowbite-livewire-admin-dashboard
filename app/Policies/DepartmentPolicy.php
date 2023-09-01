<?php

namespace App\Policies;

use App\Models\User;
use App\Enums\CanView;
use App\Models\Department;
use Illuminate\Auth\Access\Response;

class DepartmentPolicy
{
    private $parent = "departments";

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
    public function update(User $user, Department $department): bool
    {
        return $user->can("update_$this->parent") || ($user->can("update_own_$this->parent") && $user->id == $department->created_by);
    }


    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Department $department): bool
    {
        return $user->can("delete_$this->parent") || ($user->can("delete_own_$this->parent") && $user->id == $department->created_by);
    }


    /**
     * Determine whether the user can view models.
     * Also determines the permission type for all records or only for own records
     *
     */
    public function view(User $user) //: CanView | false
    {
        if ($user->can("view_$this->parent")) return Response::allow(code: CanView::All);

        if ($user->can("view_own_$this->parent")) return Response::allow(code: CanView::OWN);

        return Response::deny();
    }
}
