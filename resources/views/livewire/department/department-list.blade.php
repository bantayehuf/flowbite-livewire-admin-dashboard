<div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg w-full overflow-hidden">

    {{-- Full page loading indicator spinner, add the targeting action in target attribute "target1, target2. ..."  --}}
    <x-spinner.full-page target="nextPage, previousPage, perPage, showDepartmentDetail, initEditDepartment" />

    <div class="flex flex-col lg:flex-row items-center justify-between space-y-5 lg:space-y-0 md:space-x-4 p-4">

        <div class="w-full lg:w-1/2">
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass text-gray-500 dark:text-gray-400" wire:loading.remove
                        wire:target="searchQuery"></i>
                    <x-spinner.inline wire:target="searchQuery" />
                </div>
                <input type="search" wire:model.live.debounce.800ms="searchQuery"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Search" required="">
            </div>
        </div>

        <div
            class="w-full md:w-auto flex flex-col md:flex-row space-y-5 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">

            @can('create', App\Models\Department::class)
                <x-inputs.button-primary class="w-full md:w-auto"
                    x-on:click="()=>{
                    {{-- Resting form value, if found --}}
                    if($wire.get('form.name')){
                        $wire.set('form.name', '', false);
                    }

                    $dispatch('show-department-management-modal', {title: 'Add New Department', actionName: 'addDepartment'})
                }">
                    <i class="fa-solid fa-plus mr-2"></i>
                    {{ __('Add department') }}
                </x-inputs.button-primary>
            @endcan

            <div class="flex items-center space-x-3 w-full md:w-auto">
                {{-- <x-inputs.button-outlined class="w-full md:w-auto">
                    <i class="fa-solid fa-upload mr-2"></i>
                    {{ __('Export') }}
                </x-inputs.button-outlined> --}}

                <x-inputs.button-outlined class="w-full md:w-auto">
                    <i class="fa-solid fa-upload mr-2"></i>
                    {{ __('Export') }}
                </x-inputs.button-outlined>
            </div>
        </div>
    </div>

    {{-- Modal to add and edit Department --}}
    <x-modal.modal eventName="department-management">
        <template x-if="action.actionName == 'addDepartment'">
            <form wire:submit="addDepartment" method="POST">
                <x-inputs.form-input type="text" id="form.name" label="Department Name"
                    placeholder="Enter department name" required extra="wire:model='form.name'" />

                <x-inputs.modal-form-buttons label="{{ __('Add Department') }}" actionTarget="addDepartment" />
            </form>
        </template>

        <template x-if="action.actionName == 'editDepartment'">
            <form wire:submit="editDepartment" method="POST">
                <x-inputs.form-input type="text" id="form.name" label="Department Name"
                    placeholder="Enter department name" required extra="wire:model='form.name'" />

                <x-inputs.modal-form-buttons label="{{ __('Edit Department') }}" actionTarget="editDepartment" />
            </form>
        </template>
    </x-modal.modal>

    @if (!$departments->isEmpty())
        <!-- Delete Department Confirmation Modal -->
        <x-modal.action-dialog actionTarget="deleteDepartment" />

        {{-- Modal to show department detail --}}
        <x-modal.modal maxSize="max-w-xl" eventName="department-detail">
            @if ($departmentDetail)
                <div class="grid grid-cols-2 gap-5">
                    <div class="flex flex-col">
                        <span class="mb-1 text-gray-500 text-base dark:text-gray-400">Department Name</span>
                        <span class="text-sm font-semibold">{{ $departmentDetail->name }}</span>
                    </div>

                    <div class="flex flex-col">
                        <span class="mb-1 text-gray-500 text-base dark:text-gray-400">Created By</span>
                        <span class="text-sm font-semibold">{{ $departmentDetail->created_by }}</span>
                    </div>

                    <div class="flex flex-col">
                        <span class="mb-1 text-gray-500 text-base dark:text-gray-400">Created At</span>
                        <span class="text-sm font-semibold">{{ $departmentDetail->created_at }}</span>
                    </div>

                    <div class="flex flex-col">
                        <span class="mb-1 text-gray-500 text-base dark:text-gray-400">Updated At</span>
                        <span class="text-sm font-semibold">{{ $departmentDetail->updated_at }}</span>
                    </div>
                </div>
            @endif
        </x-modal.modal>

        <x-table.table-container>
            <x-slot name="thead">
                <x-table.th>Name</x-table.th>
                <x-table.th>Created At</x-table.th>
                <x-table.th></x-table.th>
            </x-slot>

            <x-slot name="tbody">
                @foreach ($departments as $department)
                    <x-table.tr>
                        <x-table.td>{{ $department->name }}</x-table.td>
                        <x-table.td>{{ $department->created_at }}</x-table.td>
                        <x-table.td class="flex items-center justify-end">
                            <x-table.actions>
                                <x-table.action-item>
                                    <a href="#"
                                        wire:click.prevent="showDepartmentDetail({{ $department->dep_id }})"
                                        class="flex items-center py-2 px-4 ">
                                        <i class="fa-regular fa-eye me-3"></i>
                                        {{ __('Show') }}
                                    </a>
                                </x-table.action-item>

                                @can('update', $department)
                                    <x-table.action-item>
                                        <a href="#"
                                            wire:click.prevent="initEditDepartment({{ $department->dep_id }})"
                                            class="flex items-center py-2 px-4 ">
                                            <i class="fa-solid fa-pen-to-square me-3"></i>
                                            {{ __('Edit') }}
                                        </a>
                                    </x-table.action-item>
                                @endcan

                                @if ($department->dep_id != 1)
                                    @can('delete', $department)
                                        <x-table.action-item class="text-red-500">
                                            <a href="#"
                                                x-on:click.prevent="$dispatch('show-action-dialog-modal', {payload: '{{ $department->dep_id }}', title: 'Deleting User', text: 'Are you sure you want to delete - {{ $department->name }}?'})"
                                                class="flex items-center py-2 px-4">
                                                <i class="fa-solid fa-trash-can me-3"></i>
                                                {{ __('Delete') }}
                                            </a>
                                        </x-table.action-item>
                                    @endcan
                                @endif
                            </x-table.actions>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            </x-slot>

            <x-slot name="tfooter">
                {{ $departments->links() }}
            </x-slot>
        </x-table.table-container>
    @else
        <x-empty-data />
    @endif
</div>
