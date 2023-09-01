<div>
    {{-- Full page loading indicator spinner --}}
    <x-spinner.client-full-page />

    {{-- Modal to permissions --}}
    <x-modal.modal maxSize="max-w-7xl" eventName="permissions-management">

        @if (!$permissions->isEmpty())
            <div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2 pb-4 mb-4 border-b border-b-gray-200">
                    <div>
                        <span class="font-bold me-2">Department:</span>
                        {{ $role->department }}
                    </div>
                    <div>
                        <span class="font-bold me-2">Role:</span>
                        {{ $role->name }}
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-5">
                    @foreach ($permissions as $parent => $child_perms)
                        @php
                            $list = $parent . 'List';
                        @endphp

                        <div x-data="{
                            selectAll: @entangle('selectAll.' . $parent),
                            permSet: @entangle('permSet'),
                            toggleAllCheckboxes() {
                                this.selectAll = !this.selectAll
                        
                                $refs.{{ $list }}.querySelectorAll('input[type=checkbox]').forEach(el => {
                                    el.checked = this.selectAll;
                        
                                    this.setValue(el.value, el.checked);
                                });
                            },
                            toggleSingleCheckboxes() {
                                if ($refs.{{ $parent }}.checked) {
                                    this.selectAll = false;
                                    $refs.{{ $parent }}.checked = false;
                                }
                            },
                            setValue(perm, status) {
                                this.permSet = {
                                    ...this.permSet,
                                    [perm]: status,
                                }
                            }
                        }" class="flex flex-col">

                            <div class="flex">
                                <label for="{{ $parent }}" class="flex items-center cursor-pointer">
                                    <x-inputs.checkbox x-on:click="toggleAllCheckboxes()" x-bind:checked="selectAll"
                                        x-ref="{{ $parent }}" class="cursor-pointer" id="{{ $parent }}" />
                                    <span class="ml-2 text-base text-gray-600">{{ ucfirst($parent) }}</span>
                                </label>

                                <div class="flex-1"></div>
                            </div>

                            <ul x-ref="{{ $list }}" class="pl-6 mt-1 space-y-1 list-none list-inside">
                                @foreach ($child_perms as $perm)
                                    <div class="flex">
                                        <label for="{{ $perm->id }}" class="flex items-center cursor-pointer">
                                            <x-inputs.checkbox x-bind:checked="permSet.{{ $perm->name }}"
                                                x-on:click="toggleSingleCheckboxes()"
                                                x-on:change="setValue($el.value, $el.checked)" class="cursor-pointer"
                                                id="{{ $perm->id }}" value="{{ $perm->name }}" />
                                            <span
                                                class="ml-2 text-base text-gray-600">{{ ucfirst(str_replace('_', ' ', $perm->child)) }}</span>
                                        </label>
                                        <div class="flex-1"></div>
                                    </div>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>

                <div class="mt-10">
                    <x-inputs.button-primary class="me-4" wire:click="savePermission" wire:target="savePermission">
                        <x-spinner.inline class="mr-2" wire:target="savePermission" />
                        {{ __('Save') }}
                    </x-inputs.button-primary>

                    <x-inputs.button-outlined x-on:click="mclose()" wire:target="savePermission">
                        {{ __('Cancel') }}
                    </x-inputs.button-outlined>
                </div>
            </div>
        @else
            <x-empty-data />
        @endif
    </x-modal.modal>
</div>
