<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta name="application-name" content="{{ config('app.name') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    {{-- <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> --}}

    @vite(['resources/assets/scss/app.scss', 'resources/assets/js/app.js'])

    @livewireStyles
</head>

<body class="antialiased bg-gray-50 dark:bg-gray-800">
    <x-layout.navbar />

    <x-layout.sidebar />

    <div x-data class="pb-5">

        <main :class="$store.showSidebar.on ? 'lg:ml-64' : 'lg:ml-0'" x-transition.duration.500ms
            class="px-2 sm:px-4 xl:px-6 pt-16 pb-4 lg:ml-0 h-auto">
            {{ $slot }}
        </main>

    </div>

    @stack('modals')

    <!--- Toast -->
    <script src="/plugins/toast/toast.js"></script>

    <script>
        window.addEventListener('toast', event => {
            switch (event.detail.type) {
                case 'info':
                    showNotification('info', 'Information', event.detail.message);
                    break;
                case 'success':
                    showNotification('success', 'Success', event.detail.message);
                    break;
                case 'warning':
                    showNotification('warning', 'Warning', event.detail.message);
                    break;
                case 'error':
                    showNotification('error', 'Error', event.detail.message);
                    break;
            }
        });

        function showNotification(type, title, message) {
            new Notify({
                title: `${title}!`,
                text: message,
                showCloseButton: true,
                showIcon: false,
                customClass: `c-${type}`,
                speed: 300, // animation speed
                autoclose: true,
                autotimeout: 5000
            });
        }
    </script>

    @livewireScriptConfig
</body>

</html>
