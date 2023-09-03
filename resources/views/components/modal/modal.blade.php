@props(['id' => null, 'maxSize' => 'max-w-2xl', 'eventName' => 'custom-event'])

@php
    $id = $id ?? md5($eventName);
@endphp

{{--
    Reusable regular modal skeleton.

    The eventName prop is used to set the name of event to dispatch modal show or hide event,
    it is concatinated with show-{eventName}-modal to dispach modal show,
    and close-{eventName}-modal to dispacht modal close.

    On $dispatch, the object with title property is needed to set the modal title.
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
        class="relative w-full {{ $maxSize }} max-h-full bg-white rounded-lg shadow-xl dark:bg-gray-700 transform transition-all overflow-y-auto">

        <div class="flex items-center justify-between px-4 py-2 border-b dark:border-gray-600">
            <h4 class="text-lg font-medium text-gray-900 dark:text-white" x-text="action.title"></h4>

            <button type="button" x-on:click="mclose()"
                class="text-gray-400 bg-transparent hover:text-primary-500 text-sm p-2 ml-auto inline-flex items-center focus:outline-none">
                <i class="fa-solid fa-xmark fa-xl"></i>
            </button>
        </div>

        <div class="px-5 pt-5 pb-6 text-gray-600">
            {{ $slot }}
        </div>
    </div>
</div>
