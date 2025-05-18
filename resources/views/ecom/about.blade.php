<x-ecom-home-layout>
    <x-slot name="title">
        About us
    </x-slot>

        <article class="">
        <header class="text-center text-3xl font-bold text-blue-400 my-8">About Us</header>

        <div class="grid grid-rows-[1fr_auto] lg:grid-rows-1 lg:grid-cols-[1fr_auto] gap-6 px-8 sm:px-16 mb-8 ">
                @if(isset($settings['aboutus']['description']))
                <article class="max-w-full">
                {!! $settings['aboutus']['description'] !!}
                </article>
                @endif
                @if(isset($settings['aboutus']['Image']))
                <img src="/storage/{{$settings['aboutus']['Image'] ?? ''}}" class="w-[30rem] lg:w-96 aspect-[3/2] mx-auto rounded-lg"  alt="About Us Image"/>
                @endif
        </div>
        </article>

        <section class="">
            <x-team class="mb-4 py-2 shadow-lg"/>
        </section>

        <x-why-us />

    <section class="text-center text-primary-300 py-12 space-y-4">
        <header class="text-3xl font-bold text-blue-400">Get in Touch</header>
        @if(isset($settings['contactInformation']['email']))
        <p class="text-lg">
            Email: <a href="mailto:{{$settings['contactInformation']['email']}}" class="hover:underline hover:text-blue-400">{{$settings['contactInformation']['email']}}</a>
        </p>
        @endif
        @if(isset($settings['contactInformation']['phoneNumber']))
        <p class="text-lg">
            Phone:
            <span>
                @foreach(explode(',', $settings['contactInformation']['phoneNumber']) as $number)
                    <a class="hover:underline hover:text-blue-400" href="tel:{{ trim($number) }}">{{ trim($number) }}</a>
                    @if(!$loop->last)
                        ,
                    @endif
                @endforeach
            </span>
        </p>
        @endif
        @if(isset($settings['contactInformation']['address']))
        <p class="text-lg">
            Address: <span> @if(isset($settings['contactInformation']['address_url']))
                <a href="{{ $settings['contactInformation']['address_url'] }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="hover:underline">
                    {{ $settings['contactInformation']['address'] }}
                </a>
                @else
                    {{ $settings['contactInformation']['address'] }}
                @endif</span>
        </p>
                @endif

        </section>
    </main>
</x-ecom-home-layout>
