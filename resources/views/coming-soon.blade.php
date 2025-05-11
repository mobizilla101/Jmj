<x-ecom-home-layout>
    <x-slot name="title">
        Comming Soon
    </x-slot>

    <main class="flex flex-col bg-primary-100 py-8 items-center justify-center ">
        <img src="{{asset('assets/images/logo.png')}}" class="h-[12rem] w-[12rem]" alt="" />
        <span class="relative w-[max-content] font-mono
before:absolute before:inset-0 before:animate-typewriter
before:bg-primary-100
after:absolute after:inset-0 after:w-[0.125em] after:animate-caret
after:bg-black text-2xl font-semibold text-blue-400">
            Coming Soon
        </span>
    </main>
</x-ecom-home-layout>
