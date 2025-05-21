<x-ecom-home-layout>
    <main class="py-6 px-4 mx-auto min-h-[89vh]">
        @if(isset($settings['repair_pdf']))
            <div class="w-full border shadow rounded overflow-hidden">
                <iframe
                    src="{{ asset('storage/' . $settings['repair_pdf']) }}#toolbar=0"
                    class="w-full h-full"
                    style="min-height: 80vh;"
                    frameborder="0"
                ></iframe>
            </div>
        @endif
    </main>
</x-ecom-home-layout>
