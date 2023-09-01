<?php

namespace App\Livewire\User;

use App\Models\User;
use App\Utils\Toast;
use Livewire\Component;
use App\Trait\WithDataTable;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UsersList extends Component
{
    use WithDataTable;

    #[Locked]
    public $userDetail = null;

    #[Locked]
    public $user;

    #[Locked]
    public $roles;

    public UserForm $form;

    public $userRole = null;

    public function mount()
    {
        $this->roles = collect();
    }

    public function showUserDetail($id)
    {
        Gate::authorize('manage', User::class);

        $this->userDetail = User::from('users as u')
            ->select('u.id', 'u.name', 'u.email', 'u.account_status', 'u.created_at', 'u.updated_at', 'd.name AS department', 'uu.name as created_by')
            ->with(['roles' => function ($query) {
                return $query->select('name');
            }])
            ->join('users as uu', 'uu.id', '=', 'u.created_by')
            ->join('departments as d', 'd.id', '=', 'u.department')
            ->where('u.id', '=', $id)
            ->first();

        $this->dispatch('show-user-detail-modal', title: 'User Detail');
    }

    public function addUser()
    {
        Gate::authorize('manage', User::class);

        $this->form->store();
    }

    /**
     * Admin to reset user password
     *
     * @param [type] $id
     * @return void
     */
    public function resetUserPassword($id)
    {
        Gate::authorize('manage', User::class);

        $this->form->resetPassword($id);
    }

    /**
     * To block and unblock user
     *
     * @param [type] $status
     * @return void
     */
    public function changeUserActiveStatus($status)
    {
        Gate::authorize('manage', User::class);

        $this->form->changeUserActiveStatus($status);
    }

    public function initAssignRole($id)
    {
        Gate::authorize('manage', User::class);

        $this->user = User::select('id', 'name', 'email', 'department')
            ->with(['roles' => function ($query) {
                return $query->select('id as role_id', 'name');
            }])
            ->findOrFail($id);

        $roles = $this->user->roles()->get();

        if (!$roles->isEmpty())
            $this->userRole = $roles->first()->id;

        $this->roles = DB::table('perm_roles as r')
            ->select('r.id', 'r.name')
            ->where('r.for_department', '=', $this->user->department)->get();

        $this->dispatch('show-user-management-modal',  title: 'Resting User Password', actionName: 'assignRole');
    }

    public function assignRole()
    {
        Gate::authorize('manage', User::class);

        $user = User::findOrFail($this->user->id);

        $user->syncRoles($this->userRole);

        $user->roles->pluck('name');

        Toast::success($this, 'Role has been assigned successfully!');
    }

    public function removeRole()
    {
        Gate::authorize('manage', User::class);

        $this->user->removeRole($this->userRole);

        $this->reset('userRole');
    }

    public function render()
    {
        Gate::authorize('manage', User::class);

        $users = User::from('users as u')
            ->select('u.id', 'u.name', 'u.email', 'u.account_status', 'd.name AS department')
            ->with(['roles' => function ($query) {
                return $query->select('name');
            }])
            ->join('departments as d', 'd.id', '=', 'u.department')
            ->where('u.id', '<>', Auth::id())
            ->where('u.name', 'like', '%' . $this->searchQuery . '%', 'AND')
            ->orderByDesc('u.id')
            ->paginate($this->perPage);

        return view('livewire.user.users-list', [
            'users' => $users,

            'departments' => DB::table('departments as d')
                ->select('d.id', 'd.name')
                ->where('d.id', '<>', 1)
                ->orderBy('d.name')->get(),
        ]);
    }
}
