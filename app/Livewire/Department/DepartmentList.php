<?php

namespace App\Livewire\Department;

use App\Enums\CanView;
use Livewire\Component;
use App\Models\Department;
use App\Trait\WithDataTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\Gate;

class DepartmentList extends Component
{
    use WithDataTable;

    public DepartmentForm $form;

    #[Locked]
    public $departmentDetail;

    public function showDepartmentDetail($id)
    {
        Gate::authorize('view', Department::class);

        $this->departmentDetail = DB::table('departments as d')
            ->select('d.id AS dep_id', 'd.name', 'd.created_at', 'd.updated_at', 'u.name as created_by')
            ->join('users as u', 'u.id', '=', 'd.created_by')
            ->where('d.id', '=', $id)
            ->first();

        $this->dispatch('show-department-detail-modal', title: 'Department Detail');
    }

    public function addDepartment()
    {
        Gate::authorize('create', Department::class);

        $this->form->store();
    }

    public function initEditDepartment(Department $department)
    {
        Gate::authorize('update', $department);

        $this->form->initUpdate($department);
    }

    public function editDepartment()
    {
        Gate::authorize('update', $this->form->department);

        $this->form->update();
    }

    public function deleteDepartment(Department $department)
    {
        Gate::authorize('delete', $department);

        $this->form->delete($department);
    }

    public function render()
    {
        $perm  = Gate::authorize('view', Department::class);

        $departments = Department::from('departments as d')
            ->select('d.id AS dep_id', 'd.name', 'd.created_at', 'd.created_by')
            ->where('d.name', 'like', '%' . $this->searchQuery . '%');

        if ($perm->code() === CanView::OWN) {
            $departments = $departments->where('d.created_by', '=', Auth::id(), 'AND');
        }

        return view('livewire.department.department-list', [
            'departments' => $departments
                ->orderByDesc('d.id')
                ->paginate($this->perPage),
        ]);
    }
}
