<?php

namespace App\Livewire\Role;

use App\Utils\Toast;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;

class Permissions extends Component
{
    #[Locked]
    public $role = null;

    #[Locked]
    public $perms = null;

    public $selectAll = [];

    public $permSet = [];

    public function savePermission()
    {
        Gate::authorize('create', Role::class);

        $newPermissions = [];

        foreach ($this->permSet as $key => $value) {
            if ($value === true) {
                array_push($newPermissions, $key);
            }
        }

        $this->role->syncPermissions($newPermissions);

        Toast::success($this, 'Saved successfully!');
    }

    #[On('init-permission-management')]
    public function initPermissionManagement($id)
    {
        Gate::authorize('create', Role::class);

        // No need to assign the permission for role in id 1,
        // beacause it is Super Admin role
        if ($id == 1) {
            Toast::error($this, 'Super admins have all permissions by default!');
            $this->dispatch('close-full-page-spinner');
            return;
        }

        $permCol =  DB::table('perm_permissions')
            ->select('id', 'parent', 'child', 'name')
            ->orderBy('parent')
            ->get();

        // Grouping permissions by its parent
        $this->perms = $permCol->groupBy('parent');

        $this->role = Role::findById($id, 'web');

        $department =  DB::table('departments')
            ->select('name')->where('id', '=', $this->role->for_department)->first();

        $this->role->department = $department->name;

        $role_permissions = $this->role->permissions->pluck('name');

        /**
         * Filtering already assigned permissions
         */
        foreach ($this->perms as $index => $parent) {
            $active_count = 0;
            foreach ($parent as $child) {
                if ($role_permissions->contains($child->name)) {
                    $active_count++;

                    $this->permSet[$child->name] = true;
                } else {
                    $this->permSet[$child->name] = false;
                }
            }

            // Cheking all actions are selected or not for the current parent name
            $this->selectAll[$index] = $active_count === $parent->count();
        }

        $this->dispatch('close-full-page-spinner');
        $this->dispatch('show-permissions-management-modal', title: 'Permission Management');
    }


    public function render()
    {
        return view('livewire.role.permissions', [
            'permissions' => $this->perms ?? collect(),
        ]);
    }
}
