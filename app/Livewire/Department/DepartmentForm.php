<?php

namespace App\Livewire\Department;

use Livewire\Form;
use App\Utils\Strg;
use App\Utils\Toast;
use App\Utils\Validator;
use App\Models\Department;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\Auth;

class DepartmentForm extends Form
{
    #[Locked]
    public ?Department $department;

    #[Rule('required|min:3')]
    public $name = '';


    private function set(Department $department)
    {
        $this->department = $department;

        $this->name = $department->name;
    }

    public function store()
    {
        $validated = $this->validate();

        $name = Strg::upperWordsFirst($validated['name']);

        Validator::unique('form.name', 'departments', 'name', $name);

        Department::create([
            'name' => Strg::upperWordsFirst($validated['name']),
            'created_by' => Auth::id(),
        ]);

        $this->reset();

        Toast::success($this->component, 'Department has been added successfully!');
    }

    public function initUpdate(Department $department)
    {
        $this->set($department);

        $this->component->dispatch('show-department-management-modal', title: 'Edit Department', actionName: 'editDepartment');
    }

    public function update()
    {
        $validated = $this->validate();

        $name =  Strg::upperWordsFirst($validated['name']);

        if ($name !== $this->department->name) {
            Validator::unique('form.name', 'departments', 'name', $name);

            $this->department->name =  Strg::upperWordsFirst($validated['name']);
        }

        $this->department->save();

        Toast::success($this->component, 'Department has been edited successfully!');
    }

    public function delete(Department $department)
    {
        // Department in id 1 should not be deleted,
        // beacause it is associated with Super Admin role
        if ($department->id == 1) {
            Toast::error($this->component, 'The server could not understand the request!');
            $this->component->dispatch('close-action-dialog-modal');
            return;
        }

        if (!$department->delete()) {
            Toast::error($this->component, 'The server could not understand the request!');
        } else {
            Toast::success($this->component, 'Department has been deleted successfully!');
        }

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
