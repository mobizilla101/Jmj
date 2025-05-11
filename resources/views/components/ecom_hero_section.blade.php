@php
    $sections = [
        [
            'image' => $settings['banners']['third_banner']??[],
            'mobile_image' => $settings['banners']['third_mobile_banner']??[],
            'action' => 'Buy',
            'icon' => 'assets/images/buy.gif',
            'route' => 'buy',
            'swiperClass' => 'banner-left-swiper',
            'type' => 'button'
        ],
        [
            'image' => $settings['banners']['second_banner']??[],
            'mobile_image' => $settings['banners']['second_mobile_banner']??[],
            'action' => 'Sell/Exchange',
            'icon' => 'assets/images/exchange.gif',
            'route' => 'coming-soon',
            'swiperClass' => 'banner-right-swiper',
            'type' => 'link'
        ],
        [
            'image' => $settings['banners']['first_banner']??[],
            'mobile_image' => $settings['banners']['first_mobile_banner']??[],
            'action' => 'Repair',
            'icon' => 'assets/images/toolkit.gif',
            'route' => 'coming-soon',
            'swiperClass' => 'banner-left-swiper',
            'type' => 'link'
        ]
    ];
@endphp

<main class="py-[0.2rem] bg-primary-100 mb-6">
    @foreach ($sections as $section)
    {{-- Event dispatching Slider --}}
    @if ($section['type'] === 'button')
        <div
        x-data
        @click="window.dispatchEvent(new Event('categoryPopup'))"
        class="relative w-full block overflow-hidden group">
            {{-- Desktop view slider --}}
            <div class="swiper {{ $section['swiperClass'] }} w-[100vw] sm:w-[98vw] !hidden sm:!block">
                <div class="swiper-wrapper">
                    @foreach ($section['image'] as $image)
                        <div class="swiper-slide">
                            <img src="{{ asset('storage/'.$image) }}" class="w-full h-[23vh] lg:h-[27vh]" alt="" loading="lazy" />
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Mobile view slider --}}
            <div class="swiper {{ $section['swiperClass'] }} w-[100vw] sm:w-[98vw] sm:!hidden">
                <div class="swiper-wrapper">
                    @foreach ($section['mobile_image'] as $image)
                        <div class="swiper-slide">
                            <img src="{{ asset('storage/'.$image) }}" class="w-full h-[23vh] lg:h-[27vh]" alt="" loading="lazy" />
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="h-full w-40 absolute bottom-0 right-0 z-20 flex items-end justify-end">
                <button type="button"
                class="me-3 sm:me-5 lg:me-7 mb-4 text-base font-semibold z-30
                !bg-blue-400 text-primary-100 rounded-full px-6 py-2
                group-hover:scale-[1.32] hover:scale-[1.32] transform transition-all duration-500 ease-in-out
                shadow-md hover:shadow-lg
                ">
                    {{ __($section['action']) }}
                </button>
            </div>
        </div>
    @else
    {{-- Link Slider --}}
        <a class="main__banner relative w-full block overflow-hidden group" href="{{ route($section['route']) }}">
            {{-- Desktop view slider --}}
            <div class="swiper {{ $section['swiperClass'] }} w-[100vw] sm:w-[98vw] !hidden sm:!block">
                <div class="swiper-wrapper">
                    @foreach ($section['image'] as $image)
                        <div class="swiper-slide">
                            <img src="{{ asset('storage/'.$image) }}" class="w-full h-[23vh] lg:h-[27vh]" alt="" loading="lazy" />
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Mobile view slider --}}
            <div class="swiper {{ $section['swiperClass'] }} w-[100vw] sm:w-[98vw] sm:!hidden">
                <div class="swiper-wrapper">
                    @foreach ($section['mobile_image'] as $image)
                        <div class="swiper-slide">
                            <img src="{{ asset('storage/'.$image) }}" class="w-full h-[23vh] lg:h-[27vh]" alt="" loading="lazy" />
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="banner_title_cover h-full w-40 absolute bottom-0 right-0 z-20 flex items-end justify-end">
                <button type="button"
                class="me-3 sm:me-5 lg:me-7 mb-4 text-base font-semibold z-30
                !bg-blue-400 text-primary-100 rounded-full px-6 py-2
                group-hover:scale-[1.32] hover:scale-[1.32] transform transition-all duration-500 ease-in-out
                shadow-md hover:shadow-lg
                ">
                    {{ __($section['action']) }}
                </button>
            </div>
        </a>
    @endif
    @endforeach
</main>
