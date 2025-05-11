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
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ in_array($brand->id, $this->selectedBrand) ? 'selected' : '' }}>{{ $brand->name }}</option>
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
            @if($models->isEmpty())
                <p class="text-gray-500">There are no products available for the moment.</p>
            @else
                <div class="grid grid-cols-2 xs:grid-cols-[repeat(auto-fit,minmax(11rem,auto))] place-items-center gap-3">

                    @foreach($models as $model)
                    <article
                        x-on:click='$wire.selectModel({{ $model->id }})'
                        class="group ring-2 rounded-xl bg-[#EAEAEA] overflow-hidden w-auto xs:w-44 h-full">
                        <div class="flex flex-col w-auto xs:w-44 h-full">
                            <div class="block flex-grow">
                                <img src="{{ asset('storage/' . $model->thumbnail) }}"
                                    class="rounded-lg object-contain w-32 h-40 mx-auto px-2 pt-2 group-hover:scale-110 transition-all ease-in-out"
                                    alt="" loading="lazy" />
                            </div>

                            <div class="rounded-xl bg-white relative pb-4 px-4 grow space-y-2">
                                <div
                                    class="text-center w-full
                                    py-1 px-1 -mt-3 rounded-lg bg-blue-400 block mx-auto
                                    text-primary-100 hover:text-white font-semibold text-sm xl:text-base">
                                    <header class="">{{ $model->model_no }}</header>
                                </div>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $models->links() }} <!-- Pagination Links -->
                </div>
            @endif
        </div>
    </div>

    {{-- Popup --}}
    <div x-data="{showModal : @entangle('showModal')}"
        @keydown.window.escape="$wire.deselectModel()"
        class="fixed inset-0 flex items-center justify-center z-50 bg-black/50"
        x-show="showModal"
        x-transition:enter="transition-opacity ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-cloak>
        <x-livewire.parts.parts-category-selection :parts="$this->parts" />
    </div>

    <div class="max-w-2xl space-y-4">
        @if($models)
            @foreach($models as $model)
                <article class="">
                    <header class="text-xl font-semibold mb-3">{{$model->model_no}}</header>
                    <p class="text-xs text-gray-600">{{$model->description}}</p>
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
