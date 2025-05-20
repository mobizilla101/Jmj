<div x-data="categoryModel"
    x-init="window.addEventListener('categoryPopup', () => { showModal = true; })"
    @keydown.window.escape="showModal = false"
    class="fixed inset-0 flex items-center justify-center z-50 bg-black/50"
    x-show="showModal"
    x-transition:enter="transition-opacity ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    x-cloak>

    <div class="bg-white w-fit flex flex-col items-center justify-center py-8 px-4 sm:px-8 gap-10 rounded-lg shadow-lg shadow-primary-300"
        @click.outside="showModal = false">

        <div class="flex items-center justify-center gap-4">
            <!-- Back Button when Viewing Subcategories -->
            <div x-show="isInSubCategory" class="flex">
                <button class="text-blue-400" @click="isInSubCategory = false">
                    <x-bi-arrow-left-short class="w-6 h-6 text-blue-400"/>
                </button>
            </div>

            <header class="inline capitalize text-2xl sm:text-3xl text-blue-400">What do you want to buy</header>
        </div>

        <!-- Main Category View or Subcategory View -->
        <div class="flex items-center justify-center gap-6">
            <template x-if="!isInSubCategory">
                <div class="grid content-center grid-cols-2 md:grid-cols-3 gap-6">
                    <template x-for="item in category" :key="item.name">
                        <!-- Render Category Items (only if the type is 'category') -->
                            <div class="cursor-pointer gap-2 flex flex-col items-center justify-center" @click="viewSubCategory(item)">
                                <div class="hover:ring-2 hover:ring-blue-400 rounded-md overflow-hidden w-full">
                                    <img :src="item.thumbnail" class="w-20 h-20 mx-auto"/>
                                </div>
                                <button class="text-sm bg-blue-400 rounded-full w-full py-1.5 px-4 text-white text-center" x-text="item.name"></button>
                            </div>
                    </template>
                </div>
            </template>

            <!-- Subcategory View -->
            <template x-if="isInSubCategory">
                <div class="flex items-center justify-center gap-6">
                    <template x-for="sub in currentCategory.subCategories" :key="sub.name">
                        <a :href="sub.link" class="cursor-pointer space-y-2">
                            <div class="hover:ring-2 hover:ring-blue-400 rounded-md overflow-hidden w-full">
                                <img :src="sub.thumbnail" class="w-20 h-20 mx-auto"/>
                            </div>
                            <button class="text-sm bg-blue-400 rounded-full w-full py-1.5 px-4 text-white text-center" x-text="sub.name"></button>
                        </a>
                    </template>
                </div>
            </template>
        </div>
    </div>
</div>

@push('js')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('categoryModel', () => ({
            showModal: false,
            isInSubCategory: false,
            currentCategory: null,
            category: [
                {
                    name: 'Phone',
                    thumbnail: '{{ asset("assets/images/phone.png") }}',
                    link: 'null',
                    subCategories: [
                        {
                            name: 'New',
                            thumbnail: '{{ asset("assets/images/new.png") }}',
                            link: '{{ route("buy") }}'
                        },
                        {
                            name: 'Used',
                            thumbnail: '{{ asset("assets/images/used.png") }}',
                            link: '{{ route("used") }}'
                        },
                        {
                            name: 'Refurb',
                            thumbnail: '{{ asset("assets/images/refurb.png") }}',
                            link: '{{ route("refurb") }}'
                        }
                    ],
                    type : 'category'
                },
                {
                    name: 'Accessories',
                    thumbnail: '{{ asset("assets/images/accessory.png") }}',
                    link: '{{ route("accessories.index") }}',
                    subCategories: [],
                    type : 'link'
                },
                {
                    name: 'Parts',
                    thumbnail: '{{ asset("assets/images/parts.png") }}',
                    link: '{{ route("parts") }}',
                    subCategories: [],
                    type : 'link'
                }
            ],
            viewSubCategory(item) {
                if(item.type === 'link'){
                    window.location.href= item.link
                }

                if(item.type === 'category'){
                    this.isInSubCategory = true;
                    this.currentCategory = item;
                }
            }
        }));
    });
</script>
@endpush
