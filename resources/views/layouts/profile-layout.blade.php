<x-ecom-home-layout>
    <x-slot name="title">
        Profile
    </x-slot>

    <div class="grid grid-cols-[auto_1fr] bg-primary-100">
        <x-partials._profile-sidebar />

        <main class="p-5">
            {{ $slot }}
        </main>
    </div>

</x-ecom-home-layout>
