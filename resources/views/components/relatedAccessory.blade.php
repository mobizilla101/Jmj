@props([
    "related_products"=>[],
    ])

<div class="relative">
    <div class="swiper related_swiper w-[83vw] xs:w-[86vw] sm:w-[59vw] md:w-[95vw] lg:w-[75vw] !p-[2px] xs:!pe-[17px] sm:!p-[2px]">
        <div class="swiper-wrapper">
            @foreach ($related_products as $related_product)
                <div class="swiper-slide !h-auto">
                    <x-partials._card :product="$related_product" :thumbnail="$related_product->thumbnail"
                        :title="$related_product->title" :url="route('accessories.show',$related_product)">
                            <p class="text-sm leading-4 text-gray-700 font-semibold">
                                @if ( $related_product->discount > 0 )
                                    <span>Rs. {{ $related_product->amount - ($related_product->amount * $related_product->discount / 100) }}</span>
                                @endif
                                <span class="@if ($related_product->discount > 0) line-through @endif">Rs. {{ $related_product->amount }}</span>
                            </p>
                    </x-partials._card>
                </div>
            @endforeach
        </div>
    </div>
    <x-bi-arrow-left-circle
        class="swiper-button-prev related_swiper-button-prev !top-0 !bottom-0 !my-auto !-left-2 sm:!left-4 lg:!left-10 xl:!left-6"/>
    <x-bi-arrow-right-circle
        class="swiper-button-next related_swiper-button-next !top-0 !bottom-0 !my-auto !-right-2 sm:!right-4 lg:!right-10 xl:!right-6"/>
</div>
