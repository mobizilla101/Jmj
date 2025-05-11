<x-ecom-home-layout>
    <x-slot name="title">
        Parts Category
    </x-slot>

    <main>
        {{-- <img src="{{ asset('assets/images/banner-buy.png')}}" alt="Banner" class="w-full h-32"> --}}

        <section class="my-6">
            <div x-data="{ openFilters: false }" class="">
                <div class="relative">
                    {{-- Brand Slider --}}
                    @if ($brands->isNotEmpty())
                    <form method="GET" x-data x-ref="formElem" class="mb-4">
                        @if ($filters['partsCategories'])
                            <input type="hidden" name="category" value="{{ $filters['partsCategories'] }}">
                        @endif
                        @if($filters['model'])
                            <input type="hidden" name="model" value="{{$filters['model']}}">
                        @endif
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

                <div class="relative mb-4">
                    {{-- Parts Category Slider --}}
                    @if ($partsCategories->isNotEmpty())
                        <div class="swiper category_swiper w-[80vw] md:w-[90vw] h-12 !p-[2px]">
                            <div class="swiper-wrapper">
                                @foreach ($partsCategories as $partsCategory)
                                    <a href="{{ route('parts.category',['category' => $partsCategory->id, 'brand' => $filters['brand'],'model'=>$filters['model']]) }}"
                                        x-data="{name: '{{ $partsCategory->name }}', show: false, showMobile: false, shortname: '', shortnameMobile: '', }"
                                        x-init="$nextTick(() => {
                                            show = name.length > 11;
                                            showMobile = name.length > 8;
                                            shortname = show ? name.substring(0, 10) : name;
                                            shortnameMobile = showMobile ? name.substring(0, 7) : name;
                                        })"
                                        class="swiper-slide bg-gray-200 rounded-md !flex items-center justify-center
                                        px-2 lg:px-4 py-2 hover:ring-2 hover:ring-blue-400 {{ (int)$filters['partsCategories'] === $partsCategory->id?'ring-2 ring-blue-400':'' }}">
                                        <span class="hidden md:block">
                                            <span x-text="shortname"></span>
                                            <span x-cloak x-show="show">...</span>
                                        </span>
                                        <span class="md:hidden">
                                            <span x-text="shortnameMobile"></span>
                                            <span x-cloak x-show="showMobile">...</span>
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <x-hugeicons-circle-arrow-left-01
                            class="swiper-button-prev category-button-prev !top-0 !bottom-0 !my-auto !left-4 lg:!left-10"/>
                        <x-hugeicons-circle-arrow-right-01
                            class="swiper-button-next category-button-next !top-0 !bottom-0 !my-auto !right-4 lg:!right-10"/>
                    @endif
                </div>

               <livewire:parts-category-filter :search="$filters['search']" :brand="$filters['brand']" :model="$filters['model']" :category="$filters['partsCategories']" :brands="$brands"/>
            </div>
        </section>
    </main>
</x-ecom-home-layout>
