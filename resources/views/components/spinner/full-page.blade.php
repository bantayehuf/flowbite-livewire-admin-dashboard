@props(['target' => null])

{{--
    Full page loading indicator spinner.
    It is controlled by livewire.
    Add the targeting action in target attribute "target1, target2. ..."
 --}}

<div class="ispinner-contaier" wire:loading wire:target="{{ $target }}">
    <div class="ispinner-inner">
        <div class="ispinner ispinner-large">
            <div class="ispinner-blade"></div>
            <div class="ispinner-blade"></div>
            <div class="ispinner-blade"></div>
            <div class="ispinner-blade"></div>
            <div class="ispinner-blade"></div>
            <div class="ispinner-blade"></div>
            <div class="ispinner-blade"></div>
            <div class="ispinner-blade"></div>
        </div>
    </div>
</div>
