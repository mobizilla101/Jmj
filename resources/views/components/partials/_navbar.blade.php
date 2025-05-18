<nav class="sticky top-0 z-50 shadow-md">
    {{-- Top nav --}}
    <section class="bg-primary-100 px-3 xs:px-10 md:!px-16 lg:!px-20 py-2 xs:py-4 flex items-center" x-data="{open: false}">
        {{-- Logo --}}
        <a href="{{ route('home') }}">
            <img src="{{ asset('assets/images/logo-mini.png') }}"
                alt=""
                class="w-[12rem] h-14" />
        </a>

        {{-- Search Icon --}}
        <div class="relative sm:ms-16 lg:ms-12 xl:ms-32 hidden sm:!block">
            <form action="{{ route('buy') }}">
                @csrf
                <input type="text" name="search" placeholder="Search.." class="outline-none text-lg w-auto lg:!w-96 bg-white rounded-full px-4 py-2"/>
                <x-monoicon-search class="w-5 h-5 text-blue-400 absolute top-0 bottom-0 my-auto right-0 -translate-x-3" />
            </form>
        </div>

        {{-- Login and Signup Categories button --}}
        @guest
        <div class="ms-auto hidden sm:!flex items-center justify-center gap-4">
            {{-- Categories button --}}
            {{-- <div class="ms-2">
                <button type="button"
                    @click="window.dispatchEvent(new Event('categoryPopup'))"
                    class="bg-blue-400 text-white px-3 py-2 rounded-lg"
                >
                    Categories
                </button>
            </div> --}}
            <span class="hidden lg:block me-6">
                @livewire('cart-component')
            </span>
            <a href="{{ route('login') }}"
                class="hidden lg:!block px-6 py-2 inline-block
                border border-blue-400 rounded-lg hover:text-blue-400
                font-semibold transition ease-in-out text-blue-400">
                Login
            </a>

            <a href="{{ route('register') }}"
                class="hidden lg:!block bg-blue-400 text-primary-100 font-semibold px-6 py-2 rounded-lg transition border
                border-blue-400">
                Signup
            </a>
        </div>
        @endguest

        {{-- Profile Drop --}}
        @auth

        <div x-data="{profileDrop: false}"
            @click.outside="profileDrop = false"
            class="relative items-center gap-3 ms-auto hidden lg:!flex"
            >
            <div class="me-8 inline">
            @livewire('cart-component')
        </div>
            <button type="button" @click="profileDrop = !profileDrop" class="relative">
                <img src="{{ auth()->user()->avatar}}" alt="avatar" class="w-11 h-11 ring-2 ring-blue-400 rounded-full"/>
                <x-ri-arrow-down-wide-line
                class="absolute w-5 h-5 right-0 bottom-[-0.2rem] bg-blue-400 rounded-full text-white p-[0.1rem]"
                x-bind:class="profileDrop?'transform rotate-180':''"
                />
            </button>

            <ul
                x-cloak
                x-show="profileDrop"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="transform scale-y-0 opacity-0"
                x-transition:enter-end="transform scale-y-100 opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="transform scale-y-100 opacity-100"
                x-transition:leave-end="transform scale-y-0 opacity-0"
                class="absolute right-0 top-[3.75rem] pt-2 bg-blue-400 z-10 rounded-md min-w-[12rem]
                after:content-['_'] after:border-l-[0.8rem] after:border-l-transparent
                after:border-r-[0.8rem] after:border-r-transparent
                after:border-b-[0.8rem] after:border-b-blue-400
                after:absolute after:top-[-0.7rem] after:right-[0.5rem] after:z-0
                text-primary-100 transform origin-top"
            >

                <li class="px-2 py-2 text-center capitalize text-lg">
                    <p>{{ auth()->user()->name }}
                        <span class="block text-sm text-blue-300">{{ auth()->user()->username }}</span>
                    </p>
                </li>
                <li><a href="{{ route('auth.profile') }}" class="flex items-center ps-4 py-3 text-left hover:bg-blue-900 hover:border-s-4 hover:border-blue-700"><x-css-profile class="w-5 me-4"/> Profile</a></li>

                @if(auth()->user()->user_type === App\Enum\UserType::ADMIN)
                    <li><a href="{{ route("filament.admin.pages.dashboard") }}" class="flex items-center ps-4 py-3 text-left hover:bg-blue-900 hover:border-s-4 hover:border-blue-700"><x-gmdi-admin-panel-settings-o class="w-5 me-4"/> Admin Panel</a></li>
                @endif

                {{-- <li><a href="#" class="flex items-center ps-4 py-3 text-left hover:bg-blue-900 hover:border-s-4 hover:border-blue-700"><x-feathericon-settings  class="w-5 me-4"/> Settings</a></li> --}}
                <li class="rounded-b-md overflow-hidden">
                    <form method="POST" action="{{ route("logout") }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center ps-4 py-3 text-left hover:bg-blue-900 hover:border-s-4 hover:border-blue-700">
                            <x-solar-logout-2-linear  class="w-5 me-4"/>
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
        @endauth

        {{-- Mobile view search and burger icon --}}
        <div class="ms-auto lg:!hidden flex items-center gap-6">
            {{-- Search Icon Mobile View --}}
            <div class="relative sm:!hidden" x-data="{searchOpen: false}"
                @click.outside="searchOpen = false"
                >
                <form action="{{ route('buy') }}">
                    @csrf
                    <input type="text" name="search" placeholder="Search.."
                    class="outline-none rounded-full px-4 py-2 bg-white w-36 xs:!w-44"
                    x-cloak
                    x-show="searchOpen"
                    />
                    <x-monoicon-search class="w-6 h-6 text-blue-400 absolute top-0 bottom-0 my-auto right-2" x-on:click="searchOpen = true"/>
                </form>
            </div>

            @livewire('cart-component')
            {{-- Hamburger Button --}}
            <button @click="open = true" class="text-blue-400 ms-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
        </div>

        <div
            class="fixed inset-0 z-40 flex lg:hidden"
            x-cloak
            x-bind:style="open ? 'visibility: visible; opacity: 1;' : 'visibility: hidden; opacity: 0; transition: visibility 0.3s, opacity 0.3s;'">
            {{-- Overlay --}}
            <div
                @click="open = false"
                class="fixed inset-0 bg-black"
                x-bind:style="open ? 'opacity: 0.25; transform: scale(1); transition: opacity 0.3s ease-out, transform 0.3s ease-out;' : 'opacity: 0; transform: scale(0.9); transition: opacity 0.3s ease-in, transform 0.3s ease-in;'">
            </div>

            {{-- Off-Canvas Content --}}
            <div x-data="{profileDrop: false}"
                class="relative w-3/4 max-w-sm bg-gray-100 p-4 ml-auto  overflow-y-scroll flex flex-col items-center justify-center"
                x-bind:style="open ? 'transform: translateX(0); transition: transform 0.3s ease-out;' : 'transform: translateX(100%); transition: transform 0.3s ease-in;'">

                @auth
                    {{-- Profile Dropdown --}}
                    <div
                    class="absolute top-6 left-7 z-40 flex gap-3 items-center text-primary-300 font-semibold"
                    @click="profileDrop = !profileDrop"
                    >
                        <x-css-profile class="w-12 h-12"/>
                        <div class="capitalize">{{ auth()->user()->name }}</div>
                        <x-ri-arrow-down-wide-line
                        class="w-5 h-5"
                        x-bind:class="profileDrop?'transform rotate-180':''"
                        />
                    </div>
                    <ul
                    x-cloak
                    x-show="profileDrop"
                    x-bind:class="profileDrop && 'h-full flex flex-col justify-center'"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="transform scale-y-0 opacity-0"
                    x-transition:enter-end="transform scale-y-100 opacity-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="transform scale-y-100 opacity-100"
                    x-transition:leave-end="transform scale-y-0 opacity-0"
                    class="w-full text-primary-300 font-semibold"
                    >
                        <li><x-partials._navlink :route="route('auth.profile')" class="flex items-center w-full !py-4 text-primary-300"><x-css-profile class="w-5 me-4"/>Profile</x-partials._navlink></li>

                        @if(auth()->user()->user_type === App\Enum\UserType::ADMIN)
                            <li><x-partials._navlink :route="route('filament.admin.pages.dashboard')" class="flex items-center w-full !py-4 text-primary-300"><x-gmdi-admin-panel-settings-o class="w-5 me-4"/> Admin Panel</x-partials._navlink></li>
                        @endif

                        {{-- <li><x-partials._navlink :route="route('home')" class="flex items-center w-full !py-4 text-primary-300"><x-feathericon-settings  class="w-5 me-4"/>Settings</x-partials._navlink></li> --}}
                    </ul>
                @endauth

                {{-- Close Button --}}
                <button @click="open = false" class="absolute top-9 right-4 xs:right-11 text-blue-400 z-40">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="w-full" x-bind:class="!profileDrop && 'h-full flex flex-col'">

                <ul
                x-cloak
                x-show="!profileDrop"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="transform scale-y-0 opacity-0"
                x-transition:enter-end="transform scale-y-100 opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="transform scale-y-100 opacity-100"
                x-transition:leave-end="transform scale-y-0 opacity-0"
                class="space-y-2 mt-auto"
                >
                    <li><x-partials._navlink :route="route('home')" class="flex items-center w-full !py-4 text-primary-300"><x-heroicon-o-home class="w-5 me-4"/>Home</x-partials._navlink></li>
                    <li x-data>
                        <button type="button" class="flex items-center w-full
                            px-6 py-4 text-primary-300 font-semibold transition duration-300 ease-in-out
                            hover:text-blue-400 hover:bg-primary-100"
                            x-on:click="window.dispatchEvent(new Event('categoryPopup')); open=false;">
                            <x-ik-iphone class="w-5 me-4"/>
                            Buy
                        </button>
                    </li>
                    <li><x-partials._navlink :route="route('about')" class="flex items-center w-full !py-4 text-primary-300"><x-eva-people-outline class="w-5 me-4"/>About Us</x-partials._navlink></li>
                    <li><x-partials._navlink :route="route('blog')" class="flex items-center w-full !py-4 text-primary-300"><x-hugeicons-pencil-edit-02 class="w-5 me-4"/>Blog</x-partials._navlink></li>
                    <li><x-partials._navlink :route="route('services')" class="flex items-center w-full !py-4 text-primary-300"><x-carbon-service-id class="w-5 me-4"/>Services</x-partials._navlink></li>
                </ul>

                <div class="space-y-4 mt-auto">
                    @guest
                        <a href="{{ route('login') }}"
                           class="block py-4 text-sm border border-blue-600 rounded text-center hover:text-blue-400 font-semibold text-gray-800 transition ease-in-out hover:animate-borderRotate">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                           class="block bg-blue-400 text-primary-100 font-semibold py-4 text-center rounded transition border
                       border-blue-400">
                            Signup
                        </a>
                    @endguest

                    @auth
                        <form action="{{ route('logout') }}" method="POST" class="block mt-auto">
                            @csrf
                            <button type="submit"
                                    class="block w-full bg-red-500 text-white px-4 py-2 mt-4 rounded-lg transition hover:bg-red-600">
                                Logout
                            </button>
                        </form>
                    @endauth
                </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Bottom nav --}}
    <section class="bg-blue-400 hidden lg:block">
        {{-- Desktop Nav links --}}
        <ul class="flex items-center justify-center gap-4 flex-grow">
            <li><x-partials._navlink>Home</x-partials._navlink></li>
            @if ( Route::current()->uri() !== '/' && Route::current()->uri() !== 'home' )
                <li x-data><button type="button"
                    x-on:click="window.dispatchEvent(new Event('categoryPopup'))"
                    class="relative inline-block px-6 py-2 text-primary-100 font-semibold transition duration-300 ease-in-out
                    hover:text-blue-400 hover:bg-primary-100"
                    >
                    Buy
                </button></li>
            @endif
            <li><x-partials._navlink :route="route('about')">About us</x-partials._navlink></li>
            <li><x-partials._navlink :route="route('blog')">Blog</x-partials._navlink></li>
            <li><x-partials._navlink :route="route('services')">Services</x-partials._navlink></li>
        </ul>
    </section>
</nav>

<x-category-popup/>
