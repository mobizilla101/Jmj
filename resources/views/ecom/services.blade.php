@php
    use \App\Models\Services;
    $services = Services::orderBy('sort')->get();
@endphp

<x-ecom-home-layout>
    <x-slot name='title'>
        Services
    </x-slot>

    <div class="px-8 sm:px-16 mb-12">
        <div class="my-8">
            <header class="text-center text-3xl font-bold text-blue-400 mb-4">Services</header>
            <p class="text-center text-lg text-primary-300">Explore our wide range of repair solutions for mobile devices. Choose the service that suits your needs!</p>
        </div>

        <section class="grid grid-rows-6 sm:grid-rows-2 sm:grid-cols-2 gap-8">
            @foreach ($services as $service)
                <div class="flex items-center text-primary-300 rounded-lg shadow-xl px-4 py-6 bg-primary-100 overflow-hidden group">
                    <img src="{{asset('storage/'.$service['icon'])}}" alt="{{ $service['title'] }}" class="w-28 group-hover:scale-110" />
                    <div>
                        <header class="text-2xl font-semibold mb-2 capitalize">{{ $service['title'] }}</header>
                        <p class="text-base">{{ $service['description'] }}</p>
                    </div>
                </div>
            @endforeach

        </section>
    </div>
</x-ecom-home-layout>
