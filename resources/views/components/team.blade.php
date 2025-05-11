@php
    use Illuminate\Support\Facades\Cache;
    $teamMembers = Cache::remember('team_members', 60 * 24 * 7, function () {
        return \App\Models\TeamMember::all();
    });
@endphp
<div {{$attributes->merge(['class'=>'font-sans bg-primary-100'])}}>
    <div class="px-8 md:px-12 mx-auto">
        <div class="max-w-2xl mx-auto text-center">
            <h2 class="text-blue-400 text-3xl font-extrabold">Meet our team</h2>
            <p class="text-gray-800 text-sm mt-4 leading-relaxed">Meet our team of professionals to serve you.</p>
        </div>

        <div class="grid gap-4 place-items-center grid-cols-[repeat(auto-fit,minmax(250px,1fr))] mt-12">
            @foreach($teamMembers as $teamMember)
                <div class="border rounded-lg overflow-hidden">
                    <img src="{{asset('storage/'.$teamMember->avatar)}}" class="w-full h-56 object-cover"/>

                    <div class="p-4">
                        <h4 class="text-gray-800 text-base font-bold">{{$teamMember->name}}</h4>

                        <p class="text-gray-800 text-xs mt-1">{{$teamMember?->email}}</p>
                        <p class="text-gray-800 text-xs mt-1">{{$teamMember->position}}</p>


                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
