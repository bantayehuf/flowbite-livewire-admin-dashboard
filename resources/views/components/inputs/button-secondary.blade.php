<button wire:loading.attr="disabled"
    {{ $attributes->merge(['type' => 'button', 'class' => 'px-5 py-2 text-sm font-medium text-center text-white bg-secondary-500 rounded-lg hover:bg-secondary-700 disabled:opacity-70 focus:outline-none focus:ring-2 focus:ring-secondary-300 dark:bg-secondary-600 dark:hover:bg-secondary-700 dark:focus:ring-secondary-800']) }}>
    {{ $slot }}
</button>
