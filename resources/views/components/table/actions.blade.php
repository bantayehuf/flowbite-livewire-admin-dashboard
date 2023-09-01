<span x-data="{
    show: false,
    {{-- openUp: false, --}}
    toggle() {
        if (this.show) {
            this.show = false;
            return;
        }

        this.show = true;
        {{-- this.openUp = false;

        $nextTick(() => {
            const parentPos = document.getElementById('tableParent').getBoundingClientRect().bottom;
            const panelPos = $refs.panel.getBoundingClientRect().bottom;

            this.openUp = (panelPos) > parentPos;
        }); --}}
    },
}" x-on:keydown.escape.window="show = false" {!! $attributes !!}>
    <button x-on:click="toggle()" x-ref="button"
        class="inline-flex items-center px-2 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
        type="button">
        <i class="fa-solid fa-ellipsis-vertical"></i>
    </button>

    <div x-show="show" x-ref="panel" style="display: none" x-on:click.outside="show = false" x-transition.origin.top.left
        class="absolute right-8 z-10 bg-white rounded border border-gray-300 drop-shadow-sm dark:bg-gray-700 dark:divide-gray-600">
        <ul class="text-sm text-gray-700 dark:text-gray-200">
            {{ $slot }}
        </ul>
    </div>
</span>
{{-- x-bind:class="openUp ? 'bottom-full border-b-primary-500 border-b-2' : 'top-full  border-t-primary-500 border-t-2'" --}}
