<div x-data="{openFilters: false}" class="mb-4 px-2 lg:px-6">
    <div class="lg:hidden">
        <button type="button"
        x-on:click='openFilters = !openFilters'
        class="flex items-center gap-2 bg-gray-200 px-3 py-1 rounded-md text-xl font-semibold ms-2 mb-2">
            Filters
            <x-monoicon-filter class="w-6 h-6 inline-block"/>
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-[15%_1fr] gap-6 px-2 ">
        <!-- Filter Sidebar -->
        <div
        class="space-y-6 lg:block"
        x-cloak
        x-show="openFilters || (window.innerWidth >= 1024)"
        >
            <!-- Search -->
            <div class="border border-blue-400 rounded-lg p-2">
                <header class="font-bold">Search</header>
                <div class="relative">
                    <input type="text" wire:model.lazy='search' class="w-full border rounded px-2 py-1"/>
                    <x-monoicon-search class="w-4 h-4 absolute top-0 bottom-0 my-auto right-0 me-1" />
                </div>
            </div>

            <!-- Filter by Brand -->
            <div class="border border-blue-400 rounded-lg p-2">
                    <header class="font-bold">Filter by Brand</header>
                <div
                >
                    <select
                        x-on:change="(elem)=>{
                            let text = String(elem.target.options[elem.target.selectedIndex].text);
                            $wire.updateBrand(Number(elem.target.value),text)
                        }"
                        class="w-full border rounded px-2 py-1"
                    >
                        <option value="" {{ empty($this->selectedBrand) ? 'selected' : '' }}>All Brands</option>
                        @foreach($machineryBrands as $machineryBrand)
                            <option value="{{ $machineryBrand->id }}" {{ in_array($machineryBrand->id, $this->selectedBrand) ? 'selected' : '' }}>{{ $machineryBrand->name }}</option>
                        @endforeach
                    </select>
                    @if($this->selectedBrand)
                    <div class="mt-2 text-gray-700 flex gap-3 items-center flex-wrap">
                        @foreach($this->selectedBrand as $dat)
                            <div class="bg-gray-200 px-2 py-1 rounded-md flex items-center w-fit gap-2">
                                <span>{{$dat['value']}}</span>
                                <button type="button"
                                x-on:click="(elem)=>{
                                    let button = elem.target.closest('button');
                                    $wire.removeBrand(Number(button.getAttribute('data-id')))
                                }"
                                data-id="{{$dat['id']}}"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <!-- Reset Filters -->
            <button
                wire:click="resetFilters"
                class="px-4 py-2 bg-red-500 text-white rounded shadow hover:bg-red-600"
            >
                Reset Filters
            </button>
        </div>

        <!-- Product Listing -->
        <div>
            @if($machineries->isEmpty())
                <p class="text-gray-500">There are no products available for the moment.</p>
            @else
                <div class="grid grid-cols-2 xs:grid-cols-[repeat(auto-fit,minmax(11rem,auto))] place-items-center gap-3">
                    @foreach($machineries as $machinery)
                    <x-partials._card :product='$machinery' :thumbnail="$machinery->thumbnail" :title="$machinery->title" :url="route('machine.show',$machinery)">
                        <p class="text-sm leading-4 text-gray-700 font-semibold">
                            @if ( $machinery->discount > 0 )
                                <span>{{$settings['currency'] ?? 'Rs '}}. {{ $machinery->amount - ($machinery->amount * $machinery->discount / 100) }}</span>
                            @endif
                            <span class="@if ($machinery->discount > 0) line-through @endif">{{$settings['currency'] ?? 'Rs '}}. {{ $machinery->amount }}</span>
                        </p>
                    </x-partials._card>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $machineries->links() }} <!-- Pagination Links -->
                </div>
            @endif
        </div>
    </div>
    <div class="max-w-2xl space-y-4">
        @if($machineries)
            @foreach($machineries as $machinery)
                <article class="">
                    <header class="text-xl font-semibold mb-3">{{$machinery->title}}</header>
                    <p class="text-xs text-gray-600">{{$machinery->description}}</p>
                </article>
            @endforeach
        @endif
    </div>
</div>

@script
<script>
    window.addEventListener('livewire:initialized', () => {
        setScreenWidth();
        window.addEventListener('resize',setScreenWidth);
    })
    function setScreenWidth(){
        $wire.setScreenWidth(window.innerWidth);
    }
</script>
@endscript
