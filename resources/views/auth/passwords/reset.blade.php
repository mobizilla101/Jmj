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
            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <input type="hidden" name="email" value="{{ $email }}">

                <x-form.input
                    type="password"
                    name="password"
                    label="password"
                    placeholder="Enter you password"
                />

                <x-form.input
                    type="password"
                    name="password_confirmation"
                    label="Confirm Password"
                    placeholder="Re-Enter you password"
                />

                <x-form.button type="submit" class="mb-4">
                            {{ __('Reset Password') }}
                </x-form.button>
            </form>
        </div>
        </main>
    </div>
</x-ecom-home-layout>
