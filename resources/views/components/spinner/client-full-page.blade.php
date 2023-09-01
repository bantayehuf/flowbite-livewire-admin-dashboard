{{--
    Full page loading indicator spinner.
    It is controlled by emitting event,
        - Emit the event /show-full-page-spinner/ to show spinner &
        - Emit the event /close-full-page-spinner/ to hide.
 --}}

<div x-data="{
    show: false,
    mopen() {
        this.show = true;
    },
    mclose() {
        this.show = false;
    },
}" x-on:show-full-page-spinner.window="mopen()" x-on:close-full-page-spinner.window="mclose()"
    x-show="show" class="ispinner-contaier" style="display: none;">
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
