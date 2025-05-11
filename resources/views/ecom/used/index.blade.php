<x-ecom-home-layout>
    <x-slot name="title">
        Used Products
    </x-slot>

    <section>
        <img src="{{ asset('assets/images/banner-buy.png') }}" class="w-full h-32 mb-2" alt="Banner" />

        <div x-data="{ openFilters: false }" class="mb-4 px-2 lg:px-6">

            <div class="relative">
                {{-- Brand Slider --}}
                @if ($brands->isNotEmpty())
                    <x-brand-card>
                        @foreach ($brands as $brand)
                            <a href="{{route('used.product.brand.search',$brand)}}" class="@if((int) $filters['brand'] === $brand->id) ring-2 ring-blue-400 @endif swiper-slide rounded-md py-1 !flex items-center justify-center hover:ring-2 hover:ring-blue-400">
                                <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{$brand->name}}"
                                     class="w-full h-full object-contain"/>
                            </a>
                        @endforeach
                    </x-brand-card>
                @endif
            </div>
           <livewire:used-filter :search="$filters['search']" :brand="$filters['brand']" :brands="$brands"/>
        </div>
    </section>
</x-ecom-home-layout>
