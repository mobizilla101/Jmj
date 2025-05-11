@php
    $testimonials = App\Models\Testimonial::all();
@endphp

@if ($testimonials->count()>0)
<x-home-sections header="Read trusted reviews from our customers">
    <div class="swiper review_swiper w-[83vw] lg:w-[92vw] !mx-4 mt-8 lg:!mx-auto">
        <div class="swiper-wrapper">
            @foreach ($testimonials as $testimonial)
                <blockquote
                    class="swiper-slide !h-auto !flex-grow bg-primary-100 shadow-lg p-4 lg:p-6 rounded-lg"
                    >

                    <div class="space-y-2 text-primary-300">
                        <div class="flex gap-3 items-center mb-4">
                            <img src="{{ asset("storage/".$testimonial->avatar) }}" alt="user avatar" class="w-12 h-12 rounded-full"/>
                            <p class="capitalize font-semibold text-sm">{{ $testimonial->username }}</p>
                        </div>

                        <div class="flex gap-1">
                            @for ($i = 0; $i < $testimonial->stars; $i++)
                                <x-eva-star class="w-4 h-4 text-blue-400"/>
                            @endfor

                            @for ($i = $testimonial->stars; $i < 5; $i++)
                                <x-eva-star-outline class="w-4 h-4 text-blue-400"/>
                            @endfor
                        </div>

                        <p class=" text-sm">
                            {{ $testimonial->description }}
                        </p>
                        <p class="text-sm font-medium sm:mt-6">
                            &mdash; {{ \Carbon\Carbon::parse($testimonial?->reviewed_date)->format('F j, Y') }}
                        </p>
                    </div>
                </blockquote>
            @endforeach
        </div>

    </div>
</x-home-sections>
@endif
