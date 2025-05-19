<x-ecom-home-layout>

    <x-slot name="title">
        {{$product->model_no}}
    </x-slot>

    <x-slot name="metaDescription">
        {{$product->description}}
    </x-slot>

    <x-slot name="metaKeywords">
        {{$product->model_no}}
    </x-slot>

    <x-slot name="metaImage">
        {{asset('storage/'.$product->thumbnail)}}
    </x-slot>

    <div>
        {{-- <img alt="Banner" src="{{ asset('assets/images/banner-buy.png')}}" class="w-full h-32"/> --}}

        <article class="my-8 max-w-[90%] xs:max-w-[80%] sm:max-w-[75%] md:max-w-[97%] lg:max-w-[93%] xl:max-w-[80%] mx-auto">
            <div>
                <h2 class="text-3xl sm:text-4xl font-semibold mb-6">
                    {{ $product->model_no }}
                </h2>
            </div>

            <section class="grid grid-rows-[auto_1fr_25.5rem] md:grid-rows-1 md:grid-cols-[22%_40%_1fr] lg:grid-cols-[22%_38%_1fr] gap-4 mb-6">
                <x-key-specs :product="$product" />
                <x-product-attachment :product="$product" />
                <livewire:product-select-form :filters="$filters" :product="$product" />
            </section>

            <section class="grid grid-cols-1 md:grid-rows-1 md:grid-cols-[54%_43%] lg:grid-cols-[58%_39%] gap-5 mb-4">
                <div class="space-y-4">
                    <div>
                        <h3 class="text-xl font-semibold mb-3">Specifications</h3>
                        <div x-data="{openMore: false}">
                            <div
                                class="specification_container overflow-hidden"
                                x-bind:class="openMore?'max-h-auto':'max-h-72'"
                            >
                                {!! str($product->specifications)->sanitizeHtml() !!}
                            </div>

                            <div class="flex items-center mt-3">
                                <hr class="w-80" />
                                <button type="button"
                                    class="bg-primary-100 text-primary-300 ps-4 pe-2 py-2 rounded-full w-40 flex justify-center gap-1 items-center hover:ring-2 hover-ring-blue-400 hover:scale-105 transition-all ease-in-out"
                                    @click="openMore = !openMore"
                                >
                                    Read <span x-text="openMore?'Less':'More'"></span>
                                    <x-solar-double-alt-arrow-down-line-duotone class="w-5 h-5 ms-1 bg-white rounded-full" x-bind:class="openMore && 'rotate-180'"/>
                                </button>
                                <hr class="w-80"/>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold mb-3">Descriptions</h3>
                        <div class="description_container text-sm">
                            {{ $product->description }}
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-xl font-semibold w-100 text-center bg-blue-400 text-white rounded-md py-2">Trending Phones</h3>
                    <x-trending :trending_products="$trending_products"/>
                </div>
            </section>

            <section class="space-y-4">
                <h3 class="text-xl font-semibold w-100 text-center bg-blue-400 text-white rounded-md py-2">Related Products</h3>
                <x-related :related_products="$related_products"/>
            </section>
        </article>

    </div>
</x-ecom-home-layout>
