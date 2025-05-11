<x-ecom-home-layout>

        <div class="sm:px-12 sm:py-2 px-2 relative lg:grid lg:grid-cols-2 ">

            <x-svg.circuit class="absolute top-0 left-0 -z-10 h-full w-full"/>


            <section class="lg:block hidden">
                <img src="{{asset('assets/images/cartoon-logo.png')}}" class="max-w-full max-h-full object-contain block mx-auto" alt=""/>
            </section>

            <main class="bg-transparent backdrop-blur-[0.15rem] bg-opacity-25 py-4 px-2 sm:p-8 rounded-xl">

                <div class="text-3xl text-center mb-4 items-center text-blue-400 font-bold">
                    <img src="{{asset('assets/images/logo-mini.png')}}" alt="" class="h-18 mb-4 lg:hidden block mx-auto"/>
                    {{ __('Reset Password') }}
                </div>

                <div class="">
                    @if (session('status'))
                        <div class="mb-4 flex items-center p-4 border-l-4 border-green-600 bg-green-100 text-green-800 rounded shadow-md" role="alert">
                            <svg class="w-6 h-6 mr-2 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="font-medium">{{ session('status') ?? 'Reset link sent successfully!' }}</p>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <x-form.input
                            type="email"
                            name="email"
                            label="Email Address"
                            placeholder="Enter you Email"
                        />

                        <x-form.button type="submit" class="mb-4">
                            {{ __('Send Password Reset Link') }}
                        </x-form.button>
                        <div class="mb-4">
                            <a href="{{route('login')}}"
                               class="font-semibold text-primary-300"
                            >

                                Remember your password? <span class="text-semibold text-blue-400 hover:text-blue-600 hover:underline"> Login</span>
                            </a>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </x-ecom-home-layout>
