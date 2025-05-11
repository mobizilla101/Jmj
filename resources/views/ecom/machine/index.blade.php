<x-ecom-home-layout>
    <x-slot name="title">
        Machine
    </x-slot>

    <main>
        {{-- <img src="{{ asset('assets/images/banner-buy.png')}}" alt="Banner" class="w-full h-32"> --}}

        <section class="my-6">
            <div class="relative">
                {{-- Brand Slider --}}
                @if ($machineryBrands->isNotEmpty())
                    <form method="GET" x-data x-ref="formElem" class="mb-4">
                        @csrf
                        @foreach($filters as $key => $value)
                            @if($value)
                                @php
                                    $name = match($key){
                                        'search' => 'search',
                                        'brand' => 'brand',
                                        'machineCategories' => 'category',
                                        default => null
                                    }
                                @endphp
                                @if($name && $name !== 'brand')
                                    <input type="hidden" name="{{$name}}" value="{{$value}}">
                                @endif
                            @endif
                        @endforeach

                        <div class="swiper brand_swiper w-[80vw] md:w-[90vw] h-20 !p-[2px]">
                            <div class="swiper-wrapper">
                                @foreach ($machineryBrands as $machineryBrand)
                                    <label for="brand-{{ $machineryBrand->id }}"
                                           class="@if((int) $filters['brand'] === $machineryBrand->id) ring-2 ring-blue-400 @endif
                                    swiper-slide rounded-md py-2 !flex items-center justify-center
                                    hover:ring-2 hover:ring-blue-400">

                                        <img src="{{ asset('storage/' . $machineryBrand->logo) }}"
                                             alt="{{$machineryBrand->name}}"
                                             class="w-full h-full object-contain"/>

                                        <input
                                            type="radio"
                                            @change="$refs.formElem.submit()"
                                            name="brand"
                                            id="brand-{{ $machineryBrand->id }}"
                                            value="{{ $machineryBrand->id }}"
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
                {{-- Machine Working Nature slider --}}
                @if ($machineWorkings->isNotEmpty())
                    <div class="swiper machine-working-swiper w-[80vw] md:w-[90vw] h-12 !p-[2px]">
                        <div class="swiper-wrapper">
                            @foreach ($machineWorkings as $machineWorking)
                                <a href="{{ route('machine',['working'=>$machineWorking->id,'brand'=>$filters['brand']] ) }}"
                                   x-data="{name: '{{ $machineWorking->name }}', showTab: false, showMobile: false, showDesktop: false, shortnameTab: '', shortnameMobile: '', shortnameDesktop: ''}"
                                   x-init="$nextTick(() => {
                                    showDesktop = name.length > 15;
                                    showTab = name.length > 11;
                                    showMobile = name.length > 8;
                                    shortnameDesktop = showDesktop ? name.substring(0, 15) : name;
                                    shortnameTab = showTab ? name.substring(0, 11) : name;
                                    shortnameMobile = showMobile ? name.substring(0, 8) : name;
                                })"
                                   class="swiper-slide bg-gray-200 rounded-md !flex items-center justify-center
                                px-2 py-2 hover:ring-2 hover:ring-blue-400
                                {{ (int)$filters['machineWorkingNatures'] === $machineWorking->id?'ring-2 ring-blue-400':'' }}">

                                <span class="md:hidden">
                                    <span x-text="shortnameMobile"></span>
                                    <span x-cloak x-show="showMobile">...</span>
                                </span>
                                    <span class="hidden md:inline-flex lg:hidden">
                                    <span x-text="shortnameTab"></span>
                                    <span x-cloak x-show="showTab">...</span>
                                </span>
                                    <span class="hidden lg:inline-flex">
                                    <span x-text="shortnameDesktop"></span>
                                    <span x-cloak x-show="showDesktop">...</span>
                                </span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <x-hugeicons-circle-arrow-left-01
                        class="swiper-button-prev machine-button-prev !top-0 !bottom-0 !my-auto !left-4 lg:!left-10"/>
                    <x-hugeicons-circle-arrow-right-01
                        class="swiper-button-next machine-button-next !top-0 !bottom-0 !my-auto !right-4 lg:!right-10"/>
                @endif
            </div>

            <div class="relative mb-4">
                {{-- Machine Category Slider --}}
                @if ($filters['brand'] || $filters['machineWorkingNatures'])
                    <div class="swiper category_swiper w-[80vw] md:w-[90vw] h-12 !p-[2px]">
                        <div class="swiper-wrapper">
                            @foreach ($machineCategories as $machineCategory)
                                @if ($machineCategory->subcategories->isNotEmpty())
                                    <div
                                        x-data="{name: '{{ $machineCategory->name }}', open: false, showDesktop: false, showTab: false, showMobile: false, shortnameDesktop: '', shortnameTab: '', shortnameMobile: '', left: 0, width: 0}"
                                        x-init="$nextTick(() => {
                                            showDesktop = name.length > 15;
                                            showTab = name.length > 11;
                                            showMobile = name.length > 8;
                                            shortnameDesktop = showDesktop ? name.substring(0, 15) : name;
                                            shortnameTab = showTab ? name.substring(0, 11) : name;
                                            shortnameMobile = showMobile ? name.substring(0, 8) : name;
                                        })"
                                        x-on:mouseenter="
                                            left=$el.getBoundingClientRect().left;
                                            width=$el.getBoundingClientRect().width;
                                            if(!open){
                                                window.dispatchEvent(new CustomEvent('machineSubcategoryPopup{{ $machineCategory->id }}',{detail: {left, width}}));
                                                open = true;
                                            }
                                        "
                                        x-on:mouseleave="
                                            if(open){
                                                window.dispatchEvent(new CustomEvent('machineSubcategoryPopup{{ $machineCategory->id }}'));
                                                open = false;
                                            }
                                        "
                                        class="swiper-slide bg-gray-200 rounded-md !flex items-center justify-center
                                        px-2 py-2 hover:ring-2 hover:ring-blue-400 {{ (int)$filters['machineCategories'] === $machineCategory->id?'ring-2 ring-blue-400':'' }}">

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
                                    <a href="{{route('machine',['category'=>$machineCategory->id,'brand'=>$filters['brand'],'search'=>$filters['search'],'working'=>$filters['machineWorkingNatures']])}}"
                                        target="_self"
                                        x-data="{name: '{{ $machineCategory->name }}', showDesktop: false, showTab: false, showMobile: false, shortnameDesktop: '', shortnameTab: '', shortnameMobile: '', left: 0, width: 0}"
                                        x-init="$nextTick(() => {
                                            showDesktop = name.length > 15;
                                            showTab = name.length > 11;
                                            showMobile = name.length > 8;
                                            shortnameDesktop = showDesktop ? name.substring(0, 15) : name;
                                            shortnameTab = showTab ? name.substring(0, 11) : name;
                                            shortnameMobile = showMobile ? name.substring(0, 8) : name;
                                        })"
                                        class="swiper-slide bg-gray-200 rounded-md !flex items-center justify-center
                                        px-2 py-2 hover:ring-2 hover:ring-blue-400 {{ (int)$filters['machineCategories'] === $machineCategory->id?'ring-2 ring-blue-400':'' }}">

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
                    <x-popup-machinery-subcategories :machineCategories='$machineCategories' :filters="$filters"/>
                </div>
            </div>

            <livewire:machine-filter :search="$filters['search']" :brand="$filters['brand']"
                                     :machineryBrands="$machineryBrands" :categories="$filters['machineCategories']"
                                     :subCategories="$filters['machineSubCategories']"
                                     :workingNature="$filters['machineWorkingNatures']"/>
        </section>
    </main>
</x-ecom-home-layout>
