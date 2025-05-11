<div {{ $attributes->merge(['class' => 'grid grid-rows-[1fr_auto] grid-cols-1 sm:grid-rows-1 sm:grid-cols-[9rem_1fr] md:grid-cols-[4rem_1fr] lg:grid-cols-[5rem_1fr] gap-2 h-full']) }}
    x-data="{
        previewSrc: '{{ asset('storage/' . $product->thumbnail) }}',
        setSelected(index) {
            document.querySelectorAll('.swiper-slide').forEach((elem, idx) => {
                elem.setAttribute('data-selected', idx === index ? 'true' : 'false');
            });
        }
    }" x-init="setSelected(0)">
    <!-- Swiper -->
    <div class="relative row-start-2 sm:row-start-auto sm:flex items-center justify-center">
        <div
            class="swiper product_attachment_swiper w-[90%] sm:w-full h-auto sm:h-[27rem] lg:h-[24rem] !p-[2px]">
            <div class="swiper-wrapper sm:!w-[calc(100%-4px)] !h-[calc(100%-2px)]">
                <!-- Main Thumbnail -->
                <div class="swiper-slide rounded-md overflow-hidden">
                    <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->model_no }} image"
                        class="w-full h-28 xs:h-36 sm:h-full object-contain"
                        x-on:click="
                            previewSrc = '{{ asset('storage/' . $product->thumbnail) }}';
                            setSelected(0);
                        " />
                </div>

                <!-- Attachments -->
                @if ($product->attachments !== 'NULL' && $product->attachments)
                    @foreach ($product->attachments as $image)
                        <div class="swiper-slide rounded-md overflow-hidden">
                            <img src="{{ asset('storage/' . $image) }}" alt="Attachment"
                                class="w-full h-28 xs:h-36 sm:h-full object-contain"
                                x-on:click="
                                    previewSrc = '{{ asset('storage/' . $image) }}';
                                    setSelected({{ $loop->index + 1 }});
                                " />
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <x-heroicon-o-arrow-up-circle
            class="swiper-button-prev product_attachment_swiper-button-prev !w-10 !h-10 bg-blue-400
            !text-white p-1 rounded-full
            -rotate-90 sm:rotate-0 !-left-2 xs:!left-0 sm:!right-0 sm:!mx-auto
            sm:!top-[3%]"/>
        <x-heroicon-o-arrow-down-circle
            class="swiper-button-next product_attachment_swiper-button-next !w-10 !h-10 bg-blue-400
            !text-white p-1 rounded-full
            -rotate-90 sm:rotate-0 !-right-2 xs:!right-0 sm:!left-0 sm:!mx-auto
            sm:!top-[97%]"/>
    </div>

    <!-- Preview Image -->
    <div class="preview_img relative row-start-1 sm:row-start-auto ring-2 ring-blue-400 rounded-xl flex justify-center items-center p-2 h-[23rem] xs:h-[25rem] sm:h-[29rem] lg:h-[25.5rem]">
        <img :src="previewSrc" alt="{{ $product->model_no }} image" class="h-full rounded-xl object-contain"
            id="img__container" />
        <div id="img_magnifier"
            class="hidden md:block absolute !top-8 !right-0 translate-x-[105%] -translate-y-4 ring-2 ring-blue-400
            w-64 h-64 pointer-events-none bg-no-repeat bg-white shadow-xl
            opacity-0 transition-[opacity] ease-in-out delay-150 z-40">
        </div>
         <div id="magnifier_box" class="fixed pointer-events-none bg-black opacity-0 w-[2.6rem] h-[2.6rem] will-change-transform top-0 left-0 transition-transform duration-75 ease-out z-40">>
         </div>
    </div>
    <style id="dynamic-styles"></style>
</div>
