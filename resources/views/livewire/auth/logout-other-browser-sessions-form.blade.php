<div>
    <h4 class="text-lg font-medium text-gray-900">
        {{ __('Manage Your Sessions') }}
    </h4>

    <p class="mt-1 text-sm text-gray-600">
        {{ __('If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.') }}
    </p>

    <div class="mt-4 col-span-4 w-full xl:w-3/4" wire:submit.prevent="updateProfileInformation" method="POST">
        @if (count($this->sessions) > 0)
            @foreach ($this->sessions as $session)
                <div class="flex items-center mt-3">
                    <div>
                        @if ($session->agent->isDesktop())
                            <i class="fa-solid fa-display fa-xl text-gray-500"></i>
                        @else
                            <i class="fa-solid fa-mobile-screen-button fa-xl text-gray-500"></i>
                        @endif
                    </div>

                    <div class="ml-3">
                        <div class="text-sm text-gray-600">
                            {{ $session->agent->platform() ? $session->agent->platform() : __('Unknown') }} -
                            {{ $session->agent->browser() ? $session->agent->browser() : __('Unknown') }}
                        </div>

                        <div>
                            <div class="text-xs text-gray-500">
                                {{ $session->ip_address }},

                                @if ($session->is_current_device)
                                    <span class="text-green-500 font-semibold">{{ __('This device') }}</span>
                                @else
                                    {{ __('Last active') }} {{ $session->last_active }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="mt-5">
                <div class="fd-lex align-items-center mt-4">
                    <x-inputs.button-secondary x-on:click.prevent="$dispatch('show-passwd-confrim-modal')">
                        {{ __('Log Out Other Sessions') }}
                    </x-inputs.button-secondary>
                </div>
            </div>

            <!-- Password Confirmation Modal -->
            <x-modal.passwd-confrim actionTarget="logoutOtherBrowserSessions" />
        @endif
    </div>
</div>
