<x-ecom-home-layout>
    <x-slot name="title">
        {{ $blog['title'] }}
    </x-slot>

    <main class="mb-8 mt-4 px-8 sm:px-24 lg:px-48">
        <article class="">
            <section class="mb-4">
                <div class="py-3 space-y-2 text-primary-300">
                    <a href="{{ route('blog') }}" class="italic hover:underline hover:text-blue-400 text-sm">
                        <x-bi-arrow-left-short class="w-6 h-6 inline-block"/>
                        Back to Blogs
                    </a>

                    <h1 class="text-5xl">{{ $blog['title'] }}</h1>
                    <p class="text-sm text-gray-400">Published on: {{ $blog->created_at->diffForHumans() }}
                        ({{ $blog->created_at->format('M/d/Y') }})</p>
                    <p class="mt-4 font-semibold text-xl">Overview</p>
                    <p class="text-lg">{{ $blog['description'] }}</p>
                </div>
                <div class="row-start-1 md:row-start-auto">
                    @if ($blog['thumbnail'])
                        <img src="{{ asset('storage/' . $blog['thumbnail']) }}" class="w-full aspect-[6/3]"
                            alt="Blog Thumbnail" />
                    @endif
                </div>
            </section>

            <section>
                <p class="text-lg">
                    {!! $blog['content'] !!}
                </p>
            </section>
        </article>
    </main>
</x-ecom-home-layout>
