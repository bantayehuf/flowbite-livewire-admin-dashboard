<?php

namespace App\Livewire\Role;

use App\Utils\Toast;
use Livewire\Component;
use App\Trait\WithDataTable;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class RolesList extends Component
{
    use WithDataTable;

    #[Locked]
    public $roleDetail = null;

    public RoleForm $form;

    public function showRoleDetail($id)
    {
        Gate::authorize('view', Role::class);

        $this->roleDetail = DB::table('perm_roles as r')
            ->select('r.id AS role_id', 'r.name', 'r.created_at', 'r.updated_at', 'd.name AS department', 'u.name as created_by')
            ->join('users as u', 'u.id', '=', 'r.created_by')
            ->join('departments as d', 'd.id', '=', 'r.for_department')
            ->where('r.id', '=', $id)
            ->first();

        $this->dispatch('show-role-detail-modal', title: 'Role Detail');
    }

    public function addRole()
    {
        Gate::authorize('create', Role::class);

        $this->form->store();
    }

    public function initEditRole($id)
    {
        Gate::authorize('update', Role::class);

        // Role in id 1 should not be edited,
        // beacause it is Super Admin role
        if ($id == 1) {
            Toast::error($this, 'The server could not understand the request!');
            return;
        }

        $this->form->initUpdate($id);
    }

    public function editRole()
    {
        Gate::authorize('update', Role::class);

        $this->form->update();
    }

    public function deleteRole($id)
    {
        Gate::authorize('delete', Role::class);

        $this->form->delete($id);
    }

    public function render()
    {
        Gate::authorize('view', Role::class);

        return view('livewire.role.roles-list', [
            'roles' => DB::table('perm_roles as r')
                ->select('r.id AS role_id', 'r.name', 'd.name AS department')
                ->join('departments as d', 'd.id', '=', 'r.for_department')
                ->where('r.name', 'like', '%' . $this->searchQuery . '%', 'AND')
                ->orderBy('d.name')
                ->orderBy('r.name')
                ->paginate($this->perPage),

            'departments' => DB::table('departments as d')
                ->select('d.id', 'd.name')
                ->where('d.id', '<>', 1)
                ->orderBy('d.name')->get(),
        ]);
    }
}
