<button wire:loading.attr="disabled"
    {{ $attributes->merge(['type' => 'button', 'class' => 'px-5 py-2 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-600 disabled:opacity-70 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800']) }}>
    {{ $slot }}
</button>
