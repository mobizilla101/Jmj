@props([
    'product' => [],
    'thumbnail' => '',
    'title' => '',
    'url' => ''
])
@php
    if(method_exists($product, 'getConfiguration')){
        $skuDetail = $product->getConfiguration();
    }
@endphp

<article {{ $attributes->merge(['class' => 'group ring-2 rounded-xl bg-white overflow-hidden w-auto xs:w-44 h-full']) }}>
    <a href="{{ $url }}" class="flex flex-col w-auto xs:w-44 h-full">
        <div class="block flex-grow relative">
            <img src="{{ asset('storage/' . $thumbnail) }}"
                class="rounded-lg object-contain w-32 h-40 mx-auto px-2 pt-2 group-hover:scale-110 transition-all ease-in-out"
                alt="" loading="lazy" />

            @if (isset($product->new) && $product->new === 1)
                <div class="absolute w-32 top-0 left-0 -translate-x-8 translate-y-4 px-11 py-1 bg-blue-400 text-sm text-primary-100 -rotate-45 text-center">
                    New
                </div>
            @endif

            @if (isset($product->featured) && $product->featured === 1)
                <div class="absolute w-32 top-0 left-0 -translate-x-8 translate-y-4 px-9 py-1 bg-blue-400 text-sm text-primary-100 -rotate-45 text-center">
                    Featured
                </div>
            @endif

            @if (isset($product->refurbed) && $product->refurbed == false)
                <div class="absolute w-32 top-0 left-0 -translate-x-8 translate-y-4 px-9 py-1 bg-blue-400 text-sm text-primary-100 -rotate-45 text-center">
                    Used
                </div>
            @endif

            @if (isset($product->refurbed) && $product->refurbed == true)
                <div class="absolute w-32 top-0 left-0 -translate-x-8 translate-y-4 px-9 py-1 bg-blue-400 text-sm text-primary-100 -rotate-45 text-center">
                    Refurb
                </div>
            @endif

            @if ( (isset($product->discount) && $product->discount !== 0) )
                <div class="absolute top-0 right-0 bg-blue-400 text-white font-semibold rounded-full px-2 py-2.5 shadow-lg">
                    -{{ $product->discount }}%
                </div>
            @endif
            @if ( (isset($skuDetail->discount) && $skuDetail->discount !== 0) )
                <div class="absolute top-0 right-0 bg-blue-400 text-white font-semibold rounded-full px-2 py-2.5 shadow-lg">
                    -{{ $skuDetail->discount }}%
                </div>
            @endif
        </div>

        <div class=" rounded-xl bg-[rgba(234,234,234,0.7)] relative pb-4 px-4 grow space-y-2">
            <div
                x-data="{show: false}"
                x-init="$nextTick(() => show = $refs.title.scrollHeight > 48)"
                x-bind:class="show && '!flex'"
                class="text-center w-full block
                py-1 px-1 -mt-3 rounded-lg bg-blue-400 mx-auto
                text-primary-100 hover:text-white font-semibold text-sm xl:text-base">

                <header x-ref="title" class="max-h-12 overflow-hidden" x-bind:class="show && 'w-[90%]'">
                    {{ $title }}
                </header>
                <span x-show="show" class="inline pt-6">...</span>
            </div>

            {{ $slot }}
        </div>
    </a>
</article>
