@php
    $poweredbies = cache()->remember('poweredbies', now()->addHours(6), function () {
        return App\Models\PoweredBy::all();
    });
@endphp

@if($poweredbies->count() > 0)
<x-home-sections header="Our Associates & Collaborators">
    <div class="swiper poweredby_swiper w-[90vw] mt-8">
        <div class="swiper-wrapper">
            @foreach ($poweredbies as $poweredby)
                <div class="swiper-slide">
                    <div class="w-full h-32 flex items-center justify-center">
                        <img src="{{ asset('storage/'.$poweredby->logo) }}" alt="{{ $poweredby?->name }}" class="max-h-32 w-full object-contain"/>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-home-sections>
@endif
