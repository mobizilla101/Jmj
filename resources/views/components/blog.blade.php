@php
    $blogs = cache()->remember('latest_published_blogs', 60, function () {
        return App\Models\Blog::latest()
            ->where('published', true)
            ->take(3)
            ->get();
    });
@endphp

<x-home-sections header="Our Blogs">
    <div class="grid grid-rows-3 md:grid-rows-1 md:grid-cols-3 content-center gap-10 md:gap-5 lg:gap-10 mt-8 mx-4 xs:mx-10 md:mx-4 lg:mx-20">
    @foreach ($blogs as $blog)
        <a href="{{ route('blog.show',$blog) }}" class="group rounded-2xl shadow-lg shadow-blue-200 overflow-hidden bg-white grid grid-rows-[10rem_1fr] md:grid-rows-[15rem_1fr] h-full">
            <img src="{{ asset('storage/'.$blog->thumbnail) }}" alt="" class="w-full h-40 md:!h-60 object-cover"/>
            <div class="ps-6 pe-3 py-3 grid grid-cols-[1fr_1.5rem] md:grid-cols-[1fr_2rem] gap-2">
                <div class="text-primary-300 space-y-1">
                    <p class="text-xs text-gray-400">
                        {{ \Carbon\Carbon::parse($blog->created_at)->format('F j, Y') }}
                    </p>
                    <header class="text-lg font-semibold capitalize">
                        {{ $blog->title }}
                    </header>
                    <p class="text-sm flex-grow">
                        {{ $blog->description }}
                    </p>
                </div>
                <x-bi-arrow-right-circle class="w-6 md:!w-8 h-6 md:!h-8 group-hover:scale-125 hover:scale-125 transition-all ease-in-out text-blue-400 mt-auto"/>
            </div>
        </a>
    @endforeach
    </div>
</x-home-sections>
