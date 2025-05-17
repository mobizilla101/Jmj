<div
    x-data="notificationComponent()"
    x-show="visible"
    x-transition
    x-cloak
    class="fixed top-[6rem] lg:top-[9rem] right-4 z-50 w-fit max-w-[88vw] lg:w-96 p-4 rounded-lg shadow-lg text-white bg-green-600"
>
    <div x-text="message"></div>
</div>
@session('success')
    <div
        x-data="{
        visible: true,
        timeout: null,
        init() {
            this.timeout = setTimeout(() => this.visible = false, 8000);
        }
    }"
        x-show="visible"
        x-transition
        x-cloak
        class="fixed top-[6rem] lg:top-[9rem] right-4 z-50 w-fit max-w-[88vw] lg:w-96 p-4 rounded-lg shadow-lg text-white bg-green-600"
    >
        <div>{{session('success')}}</div>
        @php session()->forget('success')@endphp
    </div>
@endsession

<script>
    function notificationComponent() {
        return {
            visible: false,
            message: '',
            timeout: null,

            show(message, duration = 3000) {
                this.message = message;
                this.visible = true;

                clearTimeout(this.timeout);
                this.timeout = setTimeout(() => this.visible = false, duration);
            },

            init() {
                window.addEventListener('notify', event => {
                    const { message, duration } = event.detail;
                    this.show(message, duration);
                });
            }
        }
    }
</script>
