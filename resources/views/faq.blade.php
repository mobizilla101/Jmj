<x-ecom-home-layout>
    <x-slot name="title">
        FAQs
    </x-slot>

    <main class="px-6 pt-12 pb-16 sm:pb-12 sm:px-10 lg:py-8 lg:px-24">
        <h2 class="text-4xl font-bold tracking-tight text-primary-300 sm:text-5xl text-center mb-6">
            FAQs
        </h2>

        <div class="space-y-6">
            @foreach($settings['faq'] as $setting)
                <x-partials._faq :data="$setting"/>
            @endforeach
        </div>
    </main>
</x-ecom-home-layout>
