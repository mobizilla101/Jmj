@props([
    "products"=>[]
    ])
<section class="min-h-[20svh] bg-primary-100 py-4">
    <h2 class="text-center text-3xl font-bold text-blue-400 mb-8">Popular Products</h2>
    {{-- <div class="swiper h-72 w-[95vw]">
        <div class="swiper-wrapper px-14">
        @foreach($products as $product)
        <x-partials._card
            :product="$product"
            class="swiper-slide h-12"
        />
        @endforeach
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div> --}}
</section>
