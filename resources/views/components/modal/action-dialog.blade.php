@props(['id' => null, 'actionTarget' => null, 'eventName' => 'action-dialog'])

@php
    $id = $id ?? md5($attributes->wire($actionTarget));
@endphp

{{--
    Simple action confirmation modal to confirm the events, like deleting an object.

    The action object contains 3 properties:
    1, Payload: This is the data that will be sent to the server when the action is confirmed. For example, this could be the ID of the record to be deleted from the database.
    2, This is the title of the alert modal.
    3, This is the text message that will be displayed to the user to inform them about the action.
--}}

<div x-data="{
    show: false,
    action: {},
    mopen(action) {
        this.action = action;
        this.show = true;
    },
    mclose() {
        this.show = false;
        this.action = {}
    },
}" x-on:show-{{ $eventName }}-modal.window="mopen($event.detail)"
    x-on:close-{{ $eventName }}-modal.window="mclose()" x-on:keydown.escape.window="mclose()" x-show="show"
    id="{{ $id }}"
    class="fixed w-screen h-screen z-50 inset-0 flex justify-center items-center bg-black bg-opacity-50 overflow-hidden"
    style="display: none;">

    <div x-show="show" x-trap.inert.noscroll="show" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        class="relative w-full max-w-md max-h-full bg-white rounded-lg shadow-xl dark:bg-gray-700 transform transition-all overflow-y-auto"
        x-transition:enter="ease-out duration-100">

        <div class="flex items-center justify-center px-6 pt-3">
            <h4 class="text-lg font-medium text-gray-900 dark:text-white" x-text="action.title"></h4>
        </div>

        <div class="px-6 py-6 text-gray-600 flex justify-center" x-text="action.text"></div>

        <div class="flex justify-end p-4 bg-gray-100 rounded-b-lg">
            <x-inputs.button-outlined x-on:click="mclose()" wire:target="{{ $actionTarget }}">
                {{ __('No, cancel') }}
            </x-inputs.button-outlined>

            <x-inputs.button-primary class="ms-4" wire:click="{{ $actionTarget }}(action.payload)"
                wire:target="{{ $actionTarget }}">
                <x-spinner.inline class="mr-2" wire:target="{{ $actionTarget }}" />
                {{ __('Yes, confirm') }}
            </x-inputs.button-primary>
        </div>
    </div>
</div>
