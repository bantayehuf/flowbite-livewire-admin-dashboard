<div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg w-full overflow-hidden">

    {{-- Full page loading indicator spinner, add the targeting action in target attribute "target1, target2. ..."  --}}
    <x-spinner.full-page target="nextPage, previousPage, perPage, showRoleDetail, initEditRole" />

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

            @can('create', Spatie\Permission\Models\Role::class)
                <x-inputs.button-primary class="w-full md:w-auto"
                    x-on:click="()=>{
                    {{-- Resting form value, if found --}}
                    if($wire.get('form.name')){
                        $wire.set('form.name', '', false);
                        $wire.set('form.department', '', false);
                    }

                    $dispatch('show-role-management-modal', {title: 'Add New Role', actionName: 'addRole'})
                }">
                    <i class="fa-solid fa-plus mr-2"></i>
                    {{ __('Add role') }}
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

    {{-- Modal to add and edit roles --}}
    <x-modal.modal eventName="role-management">
        <template x-if="action.actionName == 'addRole'">
            <form wire:submit="addRole" method="POST">
                @include('livewire.role.create-role-inputs')

                <x-inputs.modal-form-buttons label="{{ __('Add Role') }}" actionTarget="addRole" />
            </form>
        </template>

        <template x-if="action.actionName == 'editRole'">
            <form wire:submit="editRole" method="POST">
                <x-inputs.form-input type="text" id="form.name" label="Name" placeholder="Enter name"
                    extra="wire:model='form.name'" required />

                <x-inputs.modal-form-buttons label="{{ __('Edit Role') }}" actionTarget="editRole" />
            </form>
        </template>
    </x-modal.modal>

    @if (!$roles->isEmpty())
        <!-- Delete Role Confirmation Modal -->
        <x-modal.action-dialog actionTarget="deleteRole" />

        {{-- Modal to show role detail --}}
        <x-modal.modal maxSize="max-w-xl" eventName="role-detail">
            @if ($roleDetail)
                <div class="grid grid-cols-2 gap-5">
                    <div class="flex flex-col">
                        <span class="mb-1 text-gray-500 text-base dark:text-gray-400">Role Name</span>
                        <span class="text-sm font-semibold">{{ $roleDetail->name }}</span>
                    </div>

                    <div class="flex flex-col">
                        <span class="mb-1 text-gray-500 text-base dark:text-gray-400">Department</span>
                        <span class="text-sm font-semibold">{{ $roleDetail->department }}</span>
                    </div>

                    <div class="flex flex-col">
                        <span class="mb-1 text-gray-500 text-base dark:text-gray-400">Created By</span>
                        <span class="text-sm font-semibold">{{ $roleDetail->created_by }}</span>
                    </div>

                    <div class="flex flex-col">
                        <span class="mb-1 text-gray-500 text-base dark:text-gray-400">Created At</span>
                        <span class="text-sm font-semibold">{{ $roleDetail->created_at }}</span>
                    </div>

                    <div class="flex flex-col">
                        <span class="mb-1 text-gray-500 text-base dark:text-gray-400">Updated At</span>
                        <span class="text-sm font-semibold">{{ $roleDetail->updated_at }}</span>
                    </div>
                </div>
            @endif
        </x-modal.modal>

        <x-table.table-container>
            <x-slot name="thead">
                <x-table.th>Role</x-table.th>
                <x-table.th>Department</x-table.th>
                <x-table.th></x-table.th>
            </x-slot>

            <x-slot name="tbody">
                @foreach ($roles as $role)
                    <x-table.tr>
                        <x-table.td>{{ $role->name }}</x-table.td>
                        <x-table.td>{{ $role->department }}</x-table.td>
                        <x-table.td class="flex items-center justify-end">
                            <x-table.actions>
                                <x-table.action-item>
                                    <a href="#" wire:click.prevent="showRoleDetail({{ $role->role_id }})"
                                        class="flex items-center py-2 px-4 ">
                                        <i class="fa-regular fa-eye me-3"></i>
                                        {{ __('Show') }}
                                    </a>
                                </x-table.action-item>

                                @if ($role->role_id != 1)
                                    @can('update', Spatie\Permission\Models\Role::class)
                                        <x-table.action-item>
                                            <a href="#" wire:click.prevent="initEditRole({{ $role->role_id }})"
                                                class="flex items-center py-2 px-4 ">
                                                <i class="fa-solid fa-pen-to-square me-3"></i>
                                                {{ __('Edit') }}
                                            </a>
                                        </x-table.action-item>
                                    @endcan

                                    @can('create', Spatie\Permission\Models\Role::class)
                                        <x-table.action-item>
                                            <a href="#"
                                                x-on:click="(e)=>{
                                            e.preventDefault();
                                            $dispatch('show-full-page-spinner')
                                            $wire.call('dispatchTo','role.permissions', 'init-permission-management',{ id: {{ $role->role_id }} });
                                        }"
                                                class="flex items-center py-2 px-4 ">
                                                <i class="fa-solid fa-user-gear me-3"></i>
                                                {{ __('Permissions') }}
                                            </a>
                                        </x-table.action-item>
                                    @endcan

                                    @can('delete', Spatie\Permission\Models\Role::class)
                                        <x-table.action-item class="text-red-500">
                                            <a href="#"
                                                x-on:click.prevent="$dispatch('show-action-dialog-modal', {payload: '{{ $role->role_id }}', title: 'Deleting Role', text: 'Are you sure you want to delete - {{ $role->name }}?'})"
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
                {{ $roles->links() }}
            </x-slot>
        </x-table.table-container>
    @else
        <x-empty-data />
    @endif
</div>
