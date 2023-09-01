<button wire:loading.attr="disabled"
    {{ $attributes->merge(['type' => 'button', 'class' => 'text-center px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 disabled:opacity-70 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
