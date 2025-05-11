<x-ecom-home-layout>
    <x-slot name="title">
        Accessories
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

            <div class="relative mb-4">
                {{-- Accessory Category Slider --}}
                @if ($categories->isNotEmpty())
                    <div class="swiper category_swiper w-[80vw] md:w-[90vw] h-12 !p-[2px]">
                        <div class="swiper-wrapper">
                            @foreach ($categories as $category)
                                @if ($category->subCategories->isNotEmpty())
                                    <div
                                        x-data="{name: '{{ $category->name }}', open:false,showDesktop: false, showTab: false, showMobile: false, shortnameDesktop: '', shortnameTab: '', shortnameMobile: '', left: 0, width: 0}"
                                        x-init="$nextTick(() => {
                                            showDesktop = name.length > 15;
                                            showTab = name.length > 11;
                                            showMobile = name.length > 8;
                                            shortnameDesktop = showDesktop ? name.substring(0, 15) : name;
                                            shortnameTab = showTab ? name.substring(0, 11) : name;
                                            shortnameMobile = showMobile ? name.substring(0, 8) : name;
                                        })"
                                        x-on:mouseenter="
                                            width = $el.getBoundingClientRect().width;
                                            left = $el.getBoundingClientRect().left;
                                            if(!open){
                                                window.dispatchEvent(new CustomEvent('accessorySubcategoryPopup{{ $category->id }}', { detail: { left, width } } ));
                                                open = true;
                                            }
                                        "
                                        x-on:mouseleave="
                                            if(open){
                                                window.dispatchEvent(new CustomEvent('accessorySubcategoryPopup{{ $category->id }}'));
                                                open = false;
                                            }
                                        "
                                        class="swiper-slide bg-gray-200 rounded-md !flex items-center justify-center
                                        px-2 lg:px-4 py-2 hover:ring-2 hover:ring-blue-400 {{ (int)$filters['category'] === $category->id?'ring-2 ring-blue-400':'' }}">
                                        <span class="hidden lg:inline-flex">
                                            <span x-text="shortnameDesktop"></span>
                                            <span x-cloak x-show="showDesktop">...</span>
                                        </span>
                                        <span class="hidden md:inline-flex lg:hidden">
                                            <span x-text="shortnameTab"></span>
                                            <span x-cloak x-show="showTab">...</span>
                                        </span>
                                        <span class="md:hidden">
                                            <span x-text="shortnameMobile"></span>
                                            <span x-cloak x-show="showMobile">...</span>
                                        </span>
                                        <x-ri-arrow-down-s-fill class="w-4 h-4"/>
                                    </div>
                                @else
                                    <a href="{{route('accessories.index',['category'=>$category->id,'brand'=>$filters['brand']])}}"
                                        x-data="{name: '{{ $category->name }}', showDesktop: false, showTab: false, showMobile: false, shortnameDesktop: '', shortnameTab: '', shortnameMobile: ''}"
                                        x-init="$nextTick(() => {
                                            showDesktop = name.length > 15;
                                            showTab = name.length > 11;
                                            showMobile = name.length > 8;
                                            shortnameDesktop = showDesktop ? name.substring(0, 15) : name;
                                            shortnameTab = showTab ? name.substring(0, 11) : name;
                                            shortnameMobile = showMobile ? name.substring(0, 8) : name;
                                        })"
                                        class="swiper-slide bg-gray-200 rounded-md !flex items-center justify-center
                                        px-2 lg:px-4 py-2 hover:ring-2 hover:ring-blue-400 {{ (int)$filters['category'] === $category->id?'ring-2 ring-blue-400':'' }}">
                                        <span class="hidden lg:inline-flex">
                                            <span x-text="shortnameDesktop"></span>
                                            <span x-cloak x-show="showDesktop">...</span>
                                        </span>
                                        <span class="hidden md:inline-flex lg:hidden">
                                            <span x-text="shortnameTab"></span>
                                            <span x-cloak x-show="showTab">...</span>
                                        </span>
                                        <span class="md:hidden">
                                            <span x-text="shortnameMobile"></span>
                                            <span x-cloak x-show="showMobile">...</span>
                                        </span>
                                    </a>
                                @endif

                            @endforeach
                        </div>
                    </div>
                    <x-hugeicons-circle-arrow-left-01
                        class="swiper-button-prev category-button-prev !top-0 !bottom-0 !my-auto !left-4 lg:!left-10"/>
                    <x-hugeicons-circle-arrow-right-01
                        class="swiper-button-next category-button-next !top-0 !bottom-0 !my-auto !right-4 lg:!right-10"/>
                @endif

                <div class="relative">
                    <x-popup-accessory-subcategories :categories='$categories' :filters="$filters"/>
                </div>
            </div>

            <livewire:accessory-filter :search="$filters['search']" :brand="$filters['brand']" :brands="$brands" :categories="$filters['category']" :subCategory="$filters['subCategory']"/>
        </section>
    </main>

</x-ecom-home-layout>
