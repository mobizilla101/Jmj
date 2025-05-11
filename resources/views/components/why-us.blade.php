@php
    use \App\Models\WhyChooseUs;
    $data = WhyChooseUs::orderBy('sort')->get();
@endphp

<x-home-sections header="Why Choose Us?">
    <section class="grid grid-cols-2 lg:grid-cols-4 gap-6 mt-8 xs:px-6 md:px-16">
        @foreach ($data as $dat)
            <div class="pt-6">
                <div class="relative h-full">
                    @svg('hugeicons-customer-service-01','absolute -top-6 w-12 h-12 -mb-5 ms-4 text-primary-100 bg-blue-400 p-[0.65rem]')
                    <article class="px-4 pb-4 pt-8 ring-2 shadow-md shadow-gray-400 text-primary-300 h-full space-y-2">
                        <header class="font-semibold text-xl leading-6 capitalize">{{ $dat['title'] }}</header>
                        <p class="leading-5">{{ $dat['description'] }}</p>
                    </article>
                </div>
            </div>
        @endforeach
    </section>

    <section class="w-full text-center mt-6">
        <a href="{{ route('about') }}" class="inline-block px-6 py-3 bg-primary-300 text-primary-100 uppercase hover:shadow-lg hover:shadow-blue-300 transition-all ease-in-out">Learn more</a>
    </section>
</x-home-sections>
