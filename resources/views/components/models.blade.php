<div
    class="fixed top-0 left-0 min-h-screen w-full bg-gray-800 bg-opacity-50 flex items-center justify-center"
    x-data="{ open: false }"
    x-init="
        window.addEventListener('address', () => {
            open = true;
        });
    "
    x-show="open"
    x-cloak
>
    <div class="bg-white rounded-lg p-6 relative" x-on:click.outside="open = false">
        <button
            type="button"
            class="absolute top-2 right-2 text-gray-600"
            x-on:click="open = false"
        >
            &times;
        </button>
        {{ $slot }}
    </div>
</div>
