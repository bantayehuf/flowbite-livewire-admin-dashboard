<?php

namespace App\Livewire\Role;

use App\Utils\Strg;
use Livewire\Form;
use App\Utils\Toast;
use App\Utils\Validator;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Locked;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class RoleForm extends Form
{
    #[Locked]
    public ?Role $role;

    #[Rule('required|min:3')]
    public $name = '';

    #[Rule('required|int')]
    public $department = '';


    private function set(Role $role)
    {
        $this->role = $role;

        $this->name = $role->name;
    }

    public function store()
    {
        $validated = $this->validate();

        $name = Strg::upperWordsFirst($validated['name']);

        Validator::unique('form.name', 'perm_roles', 'name', $name);

        Role::create([
            'name' => $name,
            'for_department' => $validated['department'],
            'created_by' => Auth::id(),
            'guard_name' => 'web',
        ]);

        $this->reset();

        Toast::success($this->component, 'Role has been added successfully!');
    }

    public function initUpdate($id)
    {
        $role = Role::findOrFail($id);

        $this->set($role);

        $this->component->dispatch('show-role-management-modal', title: 'Edit Role', actionName: 'editRole');
    }

    public function update()
    {
        // Role in id 1 should not be edited,
        // beacause it is Super Admin role
        if ($this->role->id == 1) {
            Toast::error($this->component, 'The server could not understand the request!');
            return;
        }

        $validated = $this->component->validateOnly('form.name');

        $name = Strg::upperWordsFirst($validated['form']['name']);

        if ($name !== $this->role->name) {
            Validator::unique('form.name', 'perm_roles', 'name', $name);

            $this->role->name = $name;
        }

        $this->role->save();

        Toast::success($this->component, 'Role has been edited successfully!');
    }

    public function delete($id)
    {   // Role in id 1 should not be deleted,
        // beacause it is Super Admin role
        if ($id == 1) {
            Toast::error($this->component, 'The server could not understand the request!');
            $this->component->dispatch('close-action-dialog-modal');
            return;
        }

        $count = Role::destroy($id);

        if (!$count) {
            Toast::error($this->component, 'The server could not understand the request!');
            return;
        }

        Toast::success($this->component, 'Role has been deleted successfully!');

        $this->component->dispatch('close-action-dialog-modal');

        /**
         *  Reset form states, if it is already setted.
         *  It will cause crash (404) during next actions like add new object,
         *  if the deleted object is already loaded on the form state.
         */
        if ($this->name) {
            $this->reset();
        }
    }
}
