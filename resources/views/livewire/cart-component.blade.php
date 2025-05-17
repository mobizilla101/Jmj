<div class="inline" wire:poll.75ms="pollCartCount">
<a href="{{route('cart')}}" class="relative">
    <span class="absolute bg-red-400 text-white top-0 right-0 rounded-full py-1 px-2 text-xs -translate-y-3 translate-x-3">{{ $count }}</span>
    <x-bi-cart-fill class="w-6 h-6 text-blue-400 ms-auto"/>
</a>
</div>

