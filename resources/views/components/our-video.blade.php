@php
   $videos = \App\Models\YoutubeVideoList::all();
@endphp

@if ($videos->isNotEmpty())
<x-home-sections header="Our Videos">
    <div class="flex justify-center items-center overflow-hidden mt-8">
        <div class="swiper videoSwiper w-[90vw] h-1/4">
            <div class="swiper-wrapper">
                @foreach ($videos as $index => $video)
                    <div class="swiper-slide lg:!w-[30rem] md:!w-96 !w-56 relative bg-blue-400 p-4 rounded-md"
                    @click="playVideo({{ $index }})"
                    >
                        <div>
                            <iframe class="w-full" height="315"
                                src="{{ $video['url'] }}"
                                title="{{ $index }}-YouTube video player"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen
                            >
                            </iframe>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</x-home-sections>
@endif
