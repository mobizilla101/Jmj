<nav class="relative bg-white shadow-xl top-0 left-0 md:max-w-[16rem] py-6 px-4 font-[sans-serif]"
x-data='{navbarOpen: true}'
x-bind:class="navbarOpen && 'px-0 md:px-4'">
    <div class="relative flex flex-col h-full">

        <div class="flex flex-wrap md:flex-row flex-col items-center cursor-pointer py-2">
            <img src='{{ auth()->user()->avatar}}'
                class="w-12 h-12 rounded-md border-2 border-white"
                />
            <div class="text-center md:text-left md:ml-4" x-bind:class="navbarOpen && 'hidden md:block'">
                <p class="text-sm text-[#333] font-semibold">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-400 mt-0.5">{{ auth()->user()->username }}</p>
            </div>
        </div>

        <div class="relative">
            <hr class="my-6"/>
            <button type="button" x-cloak class="bg-blue-400 p-2 md:hidden text-primary-100 rounded-full absolute -right-[56%] top-[18%]"
            x-on:click="navbarOpen = !navbarOpen"
            x-bind:class="!navbarOpen && '!-right-[24%] !top-[16%]'"
            >
                <x-ri-arrow-down-wide-line class="w-4 h-4 rotate-90" x-bind:class="{'!-rotate-90' : navbarOpen}"/>
            </button>
        </div>

        <div>
            <h4 class="text-sm text-gray-400 mb-4" x-bind:class="navbarOpen && 'hidden md:block'">Profile Information</h4>
            <ul class="space-y-4 px-2 flex-1" x-bind:class="navbarOpen && 'space-y-8 md:space-y-4'">
                <li>
                    <a href="{{ route('auth.profile') }}" class="text-[#333] text-sm flex items-center hover:text-blue-600 transition-all">
                        <x-heroicon-o-user class="w-6 h-6 !mr-4" x-bind:class="navbarOpen && 'mx-auto md:mx-0'"/>
                        <span x-bind:class="navbarOpen && 'hidden md:block'">Details</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('auth.profile.security') }}" class="text-[#333] text-sm flex items-center hover:text-blue-600 transition-all">
                        <x-eos-security class="w-6 h-6 !mr-4" x-bind:class="navbarOpen && 'mx-auto md:mx-0'"/>
                        <span x-bind:class="navbarOpen && 'hidden md:block'">Security</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('auth.profile.orders') }}" class="text-[#333] text-sm flex items-center hover:text-blue-600 transition-all">
                        <x-eos-security class="w-6 h-6 !mr-4" x-bind:class="navbarOpen && 'mx-auto md:mx-0'"/>
                        <span x-bind:class="navbarOpen && 'hidden md:block'">My Orders</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>


</nav>
