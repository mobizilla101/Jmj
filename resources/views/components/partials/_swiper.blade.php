<div {{ $attributes->merge(['class'=>'relative']) }}>
    <div class="swiper product_swiper_element w-[92vw] sm:w-[85vw] h-72 sm:h-60 !p-[2px]">
        <div class="swiper-wrapper">
            {{$slot}}
        </div>
    </div>
    <x-eva-arrow-ios-back-outline
        class="!hidden sm:!flex !w-16 !h-16 swiper-button-prev product-btn-prev
        !-bottom-16 sm:!bottom-auto !top-auto sm:!top-[50%] !left-0 !right-20 mx-auto sm:!right-auto sm:mx-0"/>
    <x-eva-arrow-ios-forward-outline
        class="!hidden sm:!flex !w-16 !h-16 swiper-button-next product-btn-next
        !-bottom-16 sm:!bottom-auto !top-auto sm:!top-[50%] !left-20 !right-0 mx-auto sm:!left-auto sm:mx-0"/>
</div>
