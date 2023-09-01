@props(['text' => 'Not found'])


<div class="m-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
    <div class="fi-ta-empty-state px-6 py-10">
        <div class="mx-auto grid max-w-lg justify-items-center text-center">
            <div class="mb-4 rounded-full bg-gray-100 p-4 dark:bg-gray-500/20">
                <svg class="h-8 w-8 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 18 18">
                    <path
                        d="M1 18h16a1 1 0 0 0 1-1v-6h-4.439a.99.99 0 0 0-.908.6 3.978 3.978 0 0 1-7.306 0 .99.99 0 0 0-.908-.6H0v6a1 1 0 0 0 1 1Z" />
                    <path
                        d="M4.439 9a2.99 2.99 0 0 1 2.742 1.8 1.977 1.977 0 0 0 3.638 0A2.99 2.99 0 0 1 13.561 9H17.8L15.977.783A1 1 0 0 0 15 0H3a1 1 0 0 0-.977.783L.2 9h4.239Z" />
                </svg>
            </div>

            <h4 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">
                {{ $text }}
            </h4>
        </div>
    </div>
</div>
