<x-ecom-home-layout>
    <main class="p-0 m-0 w-screen h-screen">
        @if(isset($settings['repair_pdf']))
            <div class="w-screen h-screen">
                <iframe
                    src="{{ asset('storage/' . $settings['repair_pdf']) }}#toolbar=0&zoom=125"
                    class="w-screen h-screen block"
                    style="border: none;"
                ></iframe>

            </div>
        @endif
    </main>
</x-ecom-home-layout>
