<x-ecom-filament-layout>
    <x-slot name="title">
        Profile
    </x-slot>

    <div class="grid grid-cols-[auto_1fr] bg-primary-100">
        <x-partials._profile-sidebar />

        <main class="p-5">
            <livewire:profile-view />



    {{-- <div class="flex justify-center items-center mb-4">
        <img src="{{ auth()->user()->avatar }}" alt="avatar" class="w-40 h-40">
    </div>

    <section class="rounded-md shadow-xl bg-white px-8 py-6 max-w-2xl mx-auto">
        <h3 class="text-2xl font-bold text-blue-400 mb-4">User Details</h3>
        <div class="space-y-2 mb-5">
            <div class="flex sm:flex-row justify-between items-center flex-wrap">
                <span class="text-lg font-semibold text-primary-300">Name:</span>
                <span class="text-lg text-primary-300">{{ auth()->user()->name }}</span>
            </div>
            <div class="flex justify-between items-center flex-wrap">
                <span class="text-lg font-semibold text-primary-300">Username:</span>
                <span class="text-lg text-primary-300">{{ auth()->user()->username }}</span>
            </div>
            <div class="flex justify-between items-center flex-wrap">
                <span class="text-lg font-semibold text-primary-300">Email:</span>
                <span class="text-lg text-primary-300">{{ auth()->user()->email }}</span>
            </div>
        </div>

        <h3 class="text-2xl font-bold text-blue-400 mb-4">Address</h3>
        <div class="space-y-2 mb-5">
            <div class="flex justify-between items-center flex-wrap">
                <span class="text-lg font-semibold text-primary-300">Address:</span>
                @if (auth()->user()->phone)
                    <span class="text-lg text-primary-300">{{ auth()->user()->address }}</span>
                @else
                    <button class="text-base italic text-blue-400 hover:underline" x-on:click="window.dispatchEvent('address')">Add address</button>
                @endif
            </div>
        </div>

        <h3 class="text-2xl font-bold text-blue-400 mb-4">Contact Details</h3>
        <div class="space-y-2 mb-5">
            <div class="flex justify-between items-center flex-wrap">
                <span class="text-lg font-semibold text-primary-300">Phone number:</span>
                @if (auth()->user()->phone)
                    <span class="text-lg text-primary-300">{{ auth()->user()->phone }}</span>
                @else
                    <a href="#" class="text-base italic text-blue-400 hover:underline">Add phone number</a>
                @endif
            </div>
        </div>
    </section> --}}
    @push('models')
        <x-models eventName='address'>
            <form>
                <x-form.input label='Address:' name="address"/>
            </form>
        </x-models>
    @endpush

        </main>
    </div>

</x-ecom-filament-layout>

