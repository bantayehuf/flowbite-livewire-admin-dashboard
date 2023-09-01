<div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg w-full overflow-hidden">

    {{-- Full page loading indicator spinner, add the targeting action in target attribute "target1, target2. ..."  --}}
    <x-spinner.full-page target="nextPage, previousPage, perPage, showUserDetail, initAssignRole" />

    <div class="flex flex-col lg:flex-row items-center justify-between space-y-5 lg:space-y-0 md:space-x-4 p-4">

        <div class="w-full lg:w-1/2">
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass text-gray-500 dark:text-gray-400" wire:loading.remove
                        wire:target="search_query"></i>
                    <x-spinner.inline wire:target="searchQuery" />
                </div>
                <input type="search" wire:model.live.debounce.800ms="searchQuery"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Search" required="">
            </div>
        </div>

        <div
            class="w-full md:w-auto flex flex-col md:flex-row space-y-5 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
            <x-inputs.button-primary class="w-full md:w-auto"
                x-on:click="()=>{
                    {{-- Resting form value, if found --}}
                    if($wire.get('form.name')){
                        $wire.set('form.name', '', false);
                        $wire.set('form.email', '', false);
                        $wire.set('form.department', '', false);
                    }

                    $dispatch('show-user-management-modal', {title: 'Add New User', actionName: 'addUser'})
                }">
                <i class="fa-solid fa-plus mr-2"></i>
                {{ __('Add User') }}
            </x-inputs.button-primary>

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

    {{-- Modal to show created user --}}
    <x-modal.modal maxSize="max-w-md" eventName="created-user">
        @if ($form->createdUser['full_name'])
            <div class="grid grid-cols-2 gap-5">
                <div class="flex flex-col">
                    <span class="mb-1 text-gray-500 text-base dark:text-gray-400">Full Name</span>
                    <span class="text-sm font-semibold">{{ $form->createdUser['full_name'] }}</span>
                </div>

                <div class="flex flex-col">
                    <span class="mb-1 text-gray-500 text-base dark:text-gray-400">Email</span>
                    <span class="text-sm font-semibold">{{ $form->createdUser['email'] }}</span>
                </div>

                <div class="flex flex-col">
                    <span class="mb-1 text-gray-500 text-base dark:text-gray-400">Department</span>
                    <span class="text-sm font-semibold">{{ $form->createdUser['department'] }}</span>
                </div>

                <div class="flex flex-col">
                    <span class="mb-1 text-gray-500 text-base dark:text-gray-400">Password</span>
                    <span class="text-sm font-semibold">{{ $form->createdUser['password'] }}</span>
                </div>
            </div>
        @endif
    </x-modal.modal>

    {{-- Modal to add user and assign role --}}
    <x-modal.modal eventName="user-management">
        <template x-if="action.actionName == 'addUser'">
            <form wire:submit="addUser" method="POST">
                @include('livewire.user.create-user-inputs')

                <x-inputs.modal-form-buttons label="{{ __('Add User') }}" actionTarget="addUser" />
            </form>
        </template>

        <template x-if="action.actionName == 'assignRole'">
            @if (!$roles->isEmpty())
                <form wire:submit="assignRole" method="POST">
                    <x-inputs.form-select id="userRole" label="Role" extra="wire:model='userRole'" required>
                        <option class="text-gray-400" value="">Select role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </x-inputs.form-select>

                    <div class="flex mt-6">
                        <x-inputs.button-primary class="me-4" type="submit" wire:target="assignRole, removeRole">
                            <x-spinner.inline class="mr-2" wire:target="assignRole" />
                            {{ __('Assign Role') }}
                        </x-inputs.button-primary>

                        <x-inputs.button-danger wire:click="removeRole" wire:target="assignRole, removeRole">
                            <x-spinner.inline class="mr-2" wire:target="removeRole" />
                            {{ __('Revoke') }}
                        </x-inputs.button-danger>
                    </div>
                </form>
            @else
                <x-empty-data text="No role has been created for the user department." />
            @endif
        </template>
    </x-modal.modal>

    @if (!$users->isEmpty())
        <!-- Reset User Password Confirmation Modal -->
        <x-modal.action-dialog actionTarget="resetUserPassword" />

        <!-- User Block or Unblock Confirmation Modal -->
        <x-modal.action-dialog eventName="user-active-status-dialog" actionTarget="changeUserActiveStatus" />

        {{-- Modal to show user detail --}}
        <x-modal.modal maxSize="max-w-xl" eventName="user-detail">
            @if ($userDetail)
                <div class="grid grid-cols-2 gap-5">
                    <div class="flex flex-col">
                        <span class="mb-1 text-gray-500 text-base dark:text-gray-400">Full Name</span>
                        <span class="text-sm font-semibold">{{ $userDetail->name }}</span>
                    </div>

                    <div class="flex flex-col">
                        <span class="mb-1 text-gray-500 text-base dark:text-gray-400">Email</span>
                        <span class="text-sm font-semibold">{{ $userDetail->email }}</span>
                    </div>

                    <div class="flex flex-col">
                        <span class="mb-1 text-gray-500 text-base dark:text-gray-400">Department</span>
                        <span class="text-sm font-semibold">{{ $userDetail->department }}</span>
                    </div>

                    <div class="flex flex-col">
                        <span class="mb-1 text-gray-500 text-base dark:text-gray-400">Created By</span>
                        <span class="text-sm font-semibold">{{ $userDetail->created_by }}</span>
                    </div>

                    <div class="flex flex-col">
                        <span class="mb-1 text-gray-500 text-base dark:text-gray-400">Created At</span>
                        <span class="text-sm font-semibold">{{ $userDetail->created_at }}</span>
                    </div>

                    <div class="flex flex-col">
                        <span class="mb-1 text-gray-500 text-base dark:text-gray-400">Updated At</span>
                        <span class="text-sm font-semibold">{{ $userDetail->updated_at }}</span>
                    </div>

                    <div class="flex flex-col">
                        <span class="mb-1 text-gray-500 text-base dark:text-gray-400">Status</span>
                        <span class="text-sm font-semibold">
                            @if ($userDetail->account_status === App\Enums\UserAccountStatus::Active->value)
                                <x-badge.green>Active</x-badge.green>
                            @else
                                <x-badge.red>Locked</x-badge.red>
                            @endif
                        </span>
                    </div>

                    <div class="flex flex-col">
                        <span class="mb-1 text-gray-500 text-base dark:text-gray-400">Role</span>
                        <span class="text-sm font-semibold">
                            @if (!$userDetail->roles->isEmpty())
                                @foreach ($userDetail->roles as $role)
                                    <x-badge.default>{{ $role->name }}</x-badge.default>
                                @endforeach
                            @else
                                <x-badge.yellow>None</x-badge.yellow>
                            @endif
                        </span>
                    </div>
                </div>
            @endif
        </x-modal.modal>

        <x-table.table-container>
            <x-slot name="thead">
                <x-table.th>Name</x-table.th>
                <x-table.th>Email</x-table.th>
                <x-table.th>Department</x-table.th>
                <x-table.th>Role</x-table.th>
                <x-table.th>Status</x-table.th>
                <x-table.th></x-table.th>
            </x-slot>

            <x-slot name="tbody">
                @foreach ($users as $user)
                    <x-table.tr>
                        <x-table.td>{{ $user->name }}</x-table.td>
                        <x-table.td>{{ $user->email }}</x-table.td>
                        <x-table.td>{{ $user->department }}</x-table.td>
                        <x-table.td>
                            @if (!$user->roles->isEmpty())
                                @foreach ($user->roles as $role)
                                    <x-badge.default>{{ $role->name }}</x-badge.default>
                                @endforeach
                            @else
                                <x-badge.yellow>None</x-badge.yellow>
                            @endif
                        </x-table.td>
                        <x-table.td>
                            @if ($user->account_status === App\Enums\UserAccountStatus::Active->value)
                                <x-badge.green>Active</x-badge.green>
                            @else
                                <x-badge.red>Locked</x-badge.red>
                            @endif
                        </x-table.td>
                        <x-table.td class="flex items-center justify-end">
                            <x-table.actions>
                                <x-table.action-item>
                                    <a href="#" wire:click.prevent="showUserDetail({{ $user->id }})"
                                        class="flex items-center py-2 px-4 ">
                                        <i class="fa-regular fa-eye me-3"></i>
                                        {{ __('Show') }}
                                    </a>
                                </x-table.action-item>

                                @if ($user->account_status === App\Enums\UserAccountStatus::Active->value)
                                    <x-table.action-item>
                                        <a href="#" wire:click.prevent="initAssignRole({{ $user->id }})"
                                            class="flex items-center py-2 px-4">
                                            <i class="fa-solid fa-user-gear me-3"></i>
                                            {{ __('Set role') }}
                                        </a>
                                    </x-table.action-item>

                                    <x-table.action-item class="text-red-500">
                                        <a href="#"
                                            x-on:click.prevent="$dispatch('show-action-dialog-modal', {payload: '{{ $user->id }}', title: 'Resting User Password', text: 'Are you sure you want to reset the password for the user - {{ $user->name }}?'})"
                                            class="flex items-center py-2 px-4">
                                            <i class="fa-solid fa-key me-3"></i>
                                            {{ __('Reset password') }}
                                        </a>
                                    </x-table.action-item>
                                @endif

                                @if ($user->account_status === App\Enums\UserAccountStatus::Active->value)
                                    <x-table.action-item class="text-green-500">
                                        <a href="#"
                                            x-on:click.prevent="$dispatch('show-user-active-status-dialog-modal', {payload: {id: {{ $user->id }}, to: 0}, title: 'Resting User Password', text: 'Are you sure you want to block a user named - {{ $user->name }}?'})"
                                            class="flex items-center py-2 px-4">
                                            <i class="fa-solid fa-unlock me-3"></i>
                                            {{ __('Active >> Block') }}
                                        </a>
                                    </x-table.action-item>
                                @else
                                    <x-table.action-item class="text-red-500">
                                        <a href="#"
                                            x-on:click.prevent="$dispatch('show-user-active-status-dialog-modal', {payload: {id: {{ $user->id }}, to: 1}, title: 'Resting User Password', text: 'Are you sure you want to unblock a user named - {{ $user->name }}?'})"
                                            class="flex items-center py-2 px-4">
                                            <i class="fa-solid fa-lock me-3"></i>
                                            {{ __('Blocked >> Activate') }}
                                        </a>
                                    </x-table.action-item>
                                @endif
                            </x-table.actions>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            </x-slot>

            <x-slot name="tfooter">
                {{ $users->links() }}
            </x-slot>
        </x-table.table-container>
    @else
        <x-empty-data />
    @endif
</div>
