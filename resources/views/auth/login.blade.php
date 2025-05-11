<x-ecom-home-layout>
    <div class="sm:px-12 py-2 px-2 relative lg:grid lg:grid-cols-2 ">

        <x-svg.circuit class="absolute top-0 left-0 -z-10 h-full w-full"/>




        <main class="bg-transparent backdrop-blur-[0.15rem] bg-opacity-25 py-4 px-2 sm:p-8 rounded-xl">

            <div class="text-3xl text-center mb-4 items-center text-blue-400 font-bold">
                <img src="{{asset('assets/images/logo-mini.png')}}" alt="" class="h-18 mb-4 lg:hidden block mx-auto"/>
                {{ __('Login') }}
            </div>

            <div class="">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <x-form.input
                        type="text"
                        name="user"
                        label="Email or Username"
                        placeholder="Enter your Email or Username"
                    />


                    <x-form.input
                        type="password"
                        name="password"
                        label="password"
                        placeholder="Enter you password"
                    />

                    <div class="mb-4">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">
                            {{ __('Remember Me') }}
                                </label>
                    </div>


                    <x-form.button type="submit" class="mb-4">
                        {{ __('Login') }}
                    </x-form.button>

                    <x-partials._google_button>Login</x-partials._google_button>

                    <div class="mb-4 md:flex md:justify-between">
                        <a href="{{route('register')}}"
                           class="font-semibold text-primary-300 block sm:mb-0 mb-4"
                        >

                            Don't have an account? <span class="text-semibold text-blue-400 hover:text-blue-600 hover:underline">Sign up</span>
                        </a>
                        @if (Route::has('password.request'))
                            <a class="block font-semibold text-primary-300 hover:underline hover:text-blue-400 transition ease-in-out" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </main>
        <section class="lg:block hidden">
            <img src="{{asset('assets/images/cartoon-logo.png')}}" class="max-w-full max-h-full object-contain block mx-auto" alt=""/>
        </section>
    </div>

    </x-ecom-home-layout>
