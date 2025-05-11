<x-ecom-home-layout>
    <x-slot name="title">
        Parts
    </x-slot>

    <main>
        {{-- <img src="{{ asset('assets/images/banner-buy.png')}}" alt="Banner" class="w-full h-32"> --}}

        <section class="my-6">
            <div class="relative">
                {{-- Brand Slider --}}
                @if ($brands->isNotEmpty())
                <form method="GET" x-data x-ref="formElem" class="mb-4">
                    @csrf
                    <div class="swiper brand_swiper w-[80vw] md:w-[90vw] h-20 !p-[2px]">
                        <div class="swiper-wrapper">
                            @foreach ($brands as $brand)
                                <label for="brand-{{ $brand->id }}"
                                    class="@if((int) $filters['brand'] === $brand->id) ring-2 ring-blue-400 @endif
                                    swiper-slide rounded-md py-2 !flex items-center justify-center
                                    hover:ring-2 hover:ring-blue-400">

                                    <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{$brand->name}}"
                                        class="w-full h-full object-contain"/>

                                    <input
                                        type="radio"
                                        @change="$refs.formElem.submit()"
                                        name="brand"
                                        id="brand-{{ $brand->id }}"
                                        value="{{ $brand->id }}"
                                        class="hidden"
                                    />
                                </label>
                            @endforeach
                        </div>
                    </div>
                </form>
                @endif
            </div>

            <livewire:parts-filter :search="$filters['search']" :brand="$filters['brand']" :brands="$brands"/>
        </section>
    </main>

</x-ecom-home-layout>
