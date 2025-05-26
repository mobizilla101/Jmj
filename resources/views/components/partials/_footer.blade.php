<footer class="bg-primary-300 text-primary-100 py-8 snap-center">
    <section
        class="border-b border-b-primary-100 pb-8 mx-4  md:max-w-[80vw] md:mx-auto grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 gap-8 justify-between">
        <!-- Contact Section -->
        <article>
            <img class="my-4" src="{{ asset('assets/images/logo-mini.png') }}" alt="Company Logo"/>
            <h2 class="text-2xl mb-4 font-bold">Get In Touch</h2>
            <address class="mt-2 text-sm not-italic space-y-4">
                @if(isset($settings['contactInformation']['phoneNumber']))
                <p>
                    <x-eva-phone-call-outline class="w-6 inline-block me-2"/>
                    <span>
                    @foreach(explode(',',$settings['contactInformation']['phoneNumber']) as $number)
                            <a class="hover:underline" href="tel:{{ trim($number) }}">{{ trim($number) }}</a>
                            @if(!$loop->last)
                                |
                            @endif
                        @endforeach

                    </span>
                </p>
                @endif
                @if(isset($settings['contactInformation']['address']))
                <p>
                    <x-ionicon-location-outline class="w-6 inline-block me-2"/>
                    <span>
                        @if(isset($settings['contactInformation']['address_url']))
                        <a href="{{ $settings['contactInformation']['address_url'] }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="hover:underline">
                            {{ $settings['contactInformation']['address'] }}
                        </a>
                        @else
                        <span>
                            {{ $settings['contactInformation']['address'] }}
                        </span>
                        @endif
                    </span>
                </p>
                @endif
                @if(isset($settings['contactInformation']['email']))
                <p>
                    <x-ionicon-mail-outline class="inline-block w-6 me-2"/>
                    <a href="mailto:{{ $settings['contactInformation']['email'] }}" class="hover:underline">{{ $settings['contactInformation']['email'] }}</a>
                </p>
                @endif
            </address>
        </article>

        <!-- Quick Links and Social Media -->
        <div>
            <div class="mb-6">
                <h2 class="text-2xl mb-4 font-semibold">Quick Links</h2>
                <ul class="mt-2 space-y-2">
                    <li><a href="{{ route('home') }}" class="hover:underline">Home</a></li>
                    <li><a href="{{ route('buy') }}" class="hover:underline">Buy</a></li>
                    <li><a href="{{ route('repair') }}" class="hover:underline">Repair</a></li>
                    <li><a href="{{ route('about') }}" class="hover:underline">About Us</a></li>
                    <li><a href="{{ route('blog') }}" class="hover:underline">Blog</a></li>
                    <li><a href="{{ route('services') }}" class="hover:underline">Services</a></li>
                    <li><a href="{{ route('faq') }}" class="hover:underline">Faq</a></li>
                </ul>
            </div>
            <div>
                <h2 class="text-2xl font-semibold mb-4">Connect</h2>
                <ul class="flex gap-4 mt-2">
                    @foreach(config("social.links") as $key => $link)
                        @if($link['url'])
                        <li><a href="{{$link['url']}}" target="_blank" aria-label="{{ucfirst($key)}}">
                                {{svg($link['icon'],"w-8")}}
                            </a></li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Locate Us Section -->
        <div class="grid grid-rows-[auto_1fr]">
            <h2 class="text-2xl font-semibold">Locate Us</h2>
            <x-location/>
        </div>
    </section>

    <!-- Footer Bottom -->
    <section class="mt-8 text-center text-sm">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </section>
</footer>
