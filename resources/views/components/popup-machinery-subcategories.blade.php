@foreach ($machineCategories as $machineCategory)
    <ul class="absolute bg-white shadow-md shadow-gray-400 z-10 top-0 px-6 py-4 font-semibold space-y-2 rounded-md"
        x-data="{ showModal: false, left: 0, width: 0 }"
        x-init="window.addEventListener('machineSubcategoryPopup{{ $machineCategory->id }}', (e) => {
            showModal = !showModal;
            left = e.detail.left;
            width = e.detail.width;
        })"
        x-on:mouseenter="showModal = true"
        x-on:mouseleave="showModal = false"
        x-show="showModal"
        x-transition
        x-cloak
        x-bind:style="'left: '+left+'px; width: '+width+'px;'"
        >
        @foreach ($machineCategory->subCategories as $subCategory)
            <li class="cursor-pointer hover:text-blue-400 hover:underline">
                <a
                    class="block w-full"
                    href="{{route('machine',['category'=>$machineCategory->id,'brand'=>$filters['brand'],'subcategory'=>$subCategory->id,'search'=>$filters['search']])}}" target="_self">{{ $subCategory->name }}</a>
            </li>
        @endforeach
    </ul>
@endforeach
