@props(['id' => null, 'actionTarget' => null])

@php
    $id = $id ?? md5($attributes->wire($actionTarget));
@endphp

{{-- Password confirmation modal --}}

<div x-data="{
    show: false,
    mopen() {
        this.show = true;

        var component = this;
        setTimeout(() => component.$refs.password.focus(), 250);
    },
    mclose() {
        this.show = false;
    },
}" x-on:show-passwd-confrim-modal.window="mopen()"
    x-on:close-passwd-confrim-modal.window="mclose()" x-on:keydown.escape.window="mclose()" x-show="show"
    id="{{ $id }}"
    class="fixed w-screen h-screen z-50 inset-0 flex justify-center items-center bg-black bg-opacity-50 overflow-hidden"
    style="display: none;">

    <div x-show="show" x-trap.inert.noscroll="show" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="relative w-full max-w-xl max-h-full bg-white rounded-lg shadow-xl dark:bg-gray-700 transform transition-all overflow-y-auto">

        <div class="flex items-center justify-between px-4 py-2 border-b dark:border-gray-600">
            <h4 class="text-lg font-medium text-gray-900 dark:text-white">
                {{ __('Confirm Password') }}
            </h4>

            <button type="button" x-on:click="mclose()"
                class="text-gray-400 bg-transparent hover:text-primary-500 text-sm p-2 ml-auto inline-flex items-center focus:outline-none">
                <i class="fa-solid fa-xmark fa-xl"></i>
            </button>
        </div>

        <div class="px-4 pt-5 pb-6 text-gray-600">
            <span class="text-sm">
                {{ __('To protect your account and keep your information safe, please re-enter your password to confirm your identity and continue.') }}
            </span>

            <div class="mt-4">
                <x-inputs.input type="password" class="mt-1 block w-3/4" autocomplete="current-password"
                    placeholder="{{ __('Password') }}" x-ref="password" wire:model.defer="password"
                    wire:keydown.enter="logoutOtherBrowserSessions" />

                <x-inputs.input-error for="password" class="mt-2" />
            </div>
        </div>

        <div class="flex justify-end p-4 bg-gray-100 rounded-b-lg">
            <x-inputs.button-outlined x-on:click="mclose()" wire:target="{{ $actionTarget }}">
                {{ __('Cancel') }}
            </x-inputs.button-outlined>

            <x-inputs.button-primary class="ms-4" wire:click="{{ $actionTarget }}" wire:target="{{ $actionTarget }}">
                <x-spinner.inline class="mr-2" wire:target="{{ $actionTarget }}" />
                {{ __('Confirm') }}
            </x-inputs.button-primary>
        </div>
    </div>
</div>
