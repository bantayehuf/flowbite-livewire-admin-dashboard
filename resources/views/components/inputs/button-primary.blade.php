<button wire:loading.attr="disabled"
    {{ $attributes->merge(['type' => 'button', 'class' => 'px-5 py-2 text-sm font-medium text-center text-white bg-primary-500 rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-400 disabled:opacity-70 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800']) }}>
    {{ $slot }}
</button>
