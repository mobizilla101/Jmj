<article class="rounded-ee-xl rounded-ss-2xl overflow-hidden shadow-md" x-data="{open: false}">
    <header class="bg-gray-200 px-6 py-3 w-full text-lg font-semibold grid grid-cols-[1fr_auto] items-center gap-2"
            @click="open = !open"
    >
        <span class="">{{ $data['question'] }}</span>
        <x-eva-arrow-ios-upward-outline x-bind:class="!open && 'rotate-180'" class="w-4 h-4"/>
    </header>

    <p x-cloak
    x-show="open"
    x-transition:enter="transition-all ease-out duration-300"
    x-transition:enter-start="opacity-0 max-h-0"
    x-transition:enter-end="opacity-100 max-h-96"
    x-transition:leave="transition-all ease-in duration-300"
    x-transition:leave-start="opacity-100 max-h-96"
    x-transition:leave-end="opacity-0 max-h-0"
    class="px-6 py-4 bg-gray-100 overflow-hidden text-gray-700">
        {{ $data['answer'] }}
    </p>
</article>
