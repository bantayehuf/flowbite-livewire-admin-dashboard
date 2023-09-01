@props(['action' => null])

<li {!! $attributes->merge(['class' => 'hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white']) !!}>
    {{ $slot }}
</li>
