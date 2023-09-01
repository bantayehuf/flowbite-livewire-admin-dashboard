@props(['actionTarget' => null, 'label' => 'Click', 'extra' => ''])


<div class="flex mt-6">
    <x-inputs.button-primary class="me-4" type="submit" wire:target="{{ $actionTarget }}">
        <x-spinner.inline class="mr-2" wire:target="{{ $actionTarget }}" />
        {{ $label }}
    </x-inputs.button-primary>

    <x-inputs.button-outlined x-on:click="mclose()" wire:target="{{ $actionTarget }}">
        {{ __('Cancel') }}
    </x-inputs.button-outlined>
</div>
