@php
    $faqs = isset($settings['faq']) ? array_slice($settings['faq'],0,3):[];
@endphp

<x-home-sections header="FAQs" class="max-w-5xl">
    <div class="mt-4 space-y-4">
        @foreach($faqs as $faq)
            <x-partials._faq :data="$faq" />
        @endforeach
    </div>

    <div class="flex items-center justify-center mt-6">
        <a href="{{ route('faq') }}"
            class="bg-primary-300 text-white px-4 py-2 text-lg rounded-full
            hover:scale-110 transition-all ease-in-out shadow-lg">
            Read more
            <x-solar-double-alt-arrow-right-outline class="w-6 h-6 inline-block ms-1"/>
        </a>
    </div>
</x-home-sections>
