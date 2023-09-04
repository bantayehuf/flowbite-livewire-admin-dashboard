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

            <div class=" px-6 pt-6 xl:pb-3 space-y-6 sm:px-8">
                <h3 class="text-lg xl:text-xl text--center font-medium text-gray-900 dark:text-white">
                    Create new password
                </h3>

                <form class="mt-6" method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <x-inputs.form-input type="email" id="email" label="Email" :value="old('email', $request->email)"
                        placeholder="Enter your email" required autofocus />

                    <x-inputs.form-input type="password" id="password" label="Password"
                        placeholder="Create your password" required />

                    <x-inputs.form-input type="password" id="password_confirmation" label="Confirm Password"
                        placeholder="Confirm your password" required />

                    <x-inputs.button-primary type="submit" class="w-full mt-5">
                        {{ __('Reset Password') }}
                    </x-inputs.button-primary>

                    <div class="mt-4  flex justify-center">
                        <a class="underline text-gray-600 text-sm" href="{{ route('login') }}">
                            Login
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
