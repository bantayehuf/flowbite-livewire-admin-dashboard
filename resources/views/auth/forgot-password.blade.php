<x-guest-layout>
    <div
        class="flex flex-col items-center justify-center px-2 sm:px-4 xl:px-6 pt-8 mx-auto h-screen pt:mt-0 dark:bg-gray-900">
        <!-- Card -->
        <div class="w-full max-w-xl border-t-4 border-t-primary-500 bg-white rounded-lg shadow-md dark:bg-gray-800">

            <div class="border-b px-4 py-6">
                <a href="/"
                    class="flex items-center justify-center md:text-xl xl:text-2xl font-semibold dark:text-white">
                    <img src="/static/images/logo.png" class="mr-3 h-9 xl:h-11" alt="FlowBite Logo">
                    <span>{{ config('app.brand_name', 'AB Company') }}</span>
                </a>
            </div>

            <div class=" px-6 pt-6 xl:pb-3 space-y--6 sm:px-8">
                <h3 class="text-lg xl:text-xl text--center font-medium text-gray-900 dark:text-white">
                    Forgot your password?
                </h3>

                <p class="text-md text-gray-500 mt-2">
                    No problem. Just let us know your email address and we will email you a password reset link that
                    willallow you to choose a new one.
                </p>

                @if (session('status'))
                    <div class="mt-6 font-medium text-md text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form class="mt-6" method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <x-inputs.form-input type="email" id="email" label="Your Email" :value="old('email')"
                        placeholder="Enter your email address" required autofocus />

                    <x-inputs.button-primary type="submit" class="w-full mt-5">
                        {{ __('Reset Password') }}
                    </x-inputs.button-primary>

                    <div class="mt-4  flex justify-center">
                        <a class="underline text-gray-600 text-sm" href="{{ route('login') }}">
                            Back to login?
                        </a>
                    </div>

                    <div class="flex justify-center mt-6 mb-3">
                        @include('templates.brand')
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
