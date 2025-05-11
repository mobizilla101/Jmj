<x-ecom-home-layout>
    <x-slot name="title">
        Blogs
    </x-slot>

    <main>
        <section class="space-y-8 py-8">
            <header class="text-3xl sm:text-5xl font-bold text-primary-300 text-center">
                Our Latest Blogs
            </header>

            <div class="grid grid-rows-[repeat(5,12rem)] sm:grid-rows-[repeat(2,17rem)] lg:grid-rows-[repeat(2,15rem)] grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-4 px-8 sm:px-6 lg:px-16">
                @foreach ($latest_blogs as $latest_blog)
                <a href="{{route('blog.show',$latest_blog)}}" class="group overflow-hidden relative shadow-primary-300 shadow-md @if ($loop->first) sm:col-span-2 lg:row-span-2 @endif">
                    <img src="{{ asset('storage/'.$latest_blog->thumbnail) }}" alt="" class="w-full h-full object-cover brightness-75 hover:scale-110 group-hover:scale-110 transition-all ease-in-out"/>
                    <div class="absolute bottom-0 left-0 text-white w-full py-4 px-3 space-y-2" >
                        <header class="font-semibold leading-tight">{{$latest_blog->title}}</header>
                        <p class="text-sm leading-tight">{{$latest_blog->description}}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </section>

        @if (!$blogs)
        <section class="space-y-8 py-8">
            <header class="text-3xl sm:text-5xl font-bold text-primary-300 text-center capitalize">
                Take a Look at our Other Blogs
            </header>

            <div class="space-y-6 px-8 xs:px-6 sm:px-12 lg:px-36">
                @foreach($blogs as $blog)
                <a href="{{route('blog.show',$blog)}}" class="group grid grid-rows-[13rem_1fr] grid-cols-1 xs:grid-rows-1 xs:grid-cols-[40%_1fr] lg:grid-cols-[30%_1fr] shadow-xl rounded-lg overflow-hidden">
                    @if($blog['thumbnail'])
                        <img src="{{asset('storage/'.$blog['thumbnail'])}}" alt="" class="w-full h-full object-cover hover:scale-110 group-hover:scale-110 transition-all ease-in-out"/>
                    @endif
                    <div class="text-primary-300 px-6 py-8 space-y-4">
                        <div class="">
                            <header class="font-semibold text-lg">{{$blog->title}}</header>
                            <p class="text-sm text-gray-400 italic">
                                {{ \Carbon\Carbon::parse($blog->created_at)->format('F j, Y') }}
                            </p>
                        </div>
                        <p class="">{{$blog->description}}</p>
                        <div class="w-full flex justify-end">
                            <div class="inline-block space-y-2 italic text-lg font-semibold group-hover:scale-110 hover:scale-110 transition-all ease-in-out">
                                Read More
                                <x-bi-arrow-right class="inline w-4 h-4"/>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <div class="px-2">
                {{$blogs->links()}}
            </div>
        </section>
        @endif
    </main>
</x-ecom-home-layout>
