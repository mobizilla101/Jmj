@php
    use \App\Models\Model;
    use \App\Models\SecondhandInventory;
    use \App\Models\Accessory;
    use \App\Models\Parts;
    use \App\Models\Machinery;

    $hotSecondhands = SecondhandInventory::where('hot_sale',true)->get();
    $hotProducts = Model::where('published',true)->where('hot_sale',true)->get();

    $hotAccessories = Accessory::where('published',true)->where('hot_sale',true)->get();
    $hotParts = Parts::where('published',true)->where('hot_sale',true)->get();
    $hotMachines = Machinery::where('published',true)->where('hot_sale',true)->get();
@endphp

{{-- Hot phone swiper --}}
@if($hotProducts->count() > 0 )
<x-home-sections header="Hot Products" class="mb-4 space-y-4">
    <x-partials._swiper>
        @foreach($hotProducts as $hotProduct)
            <div class="swiper-slide">
                <x-partials._card :product='$hotProduct' :thumbnail="$hotProduct->thumbnail" :title="$hotProduct->model_no" :url="route('product.show',$hotProduct)">
                    @php
                        $skuDetail = $hotProduct->getConfiguration();
                    @endphp

                    @empty(!$skuDetail)
                        <p class="text-xs text-gray-600 font-semibold">{{ $skuDetail['memory'] }} RAM |
                            {{ $skuDetail['storage'] }}GB Storage</p>
                        <p class="text-[13px] leading-4 text-gray-700 font-semibold">
                            @if ( $skuDetail['discount'] > 0 )
                                <span>Rs. {{ $skuDetail['price'] - ($skuDetail['price'] * $skuDetail['discount'] / 100) }}</span>
                            @endif
                            <span class="@if ($skuDetail['discount'] > 0) line-through @endif">Rs. {{ $skuDetail['price'] }}</span>
                        </p>
                    @else
                        <p class="text-sm leading-4 text-gray-500">
                            No details available
                        </p>
                    @endempty
                </x-partials._card>
            </div>
        @endforeach

        @foreach($hotSecondhands as $hotSecondhand)
            <div class="swiper-slide">
                <x-partials._card :product='$hotSecondhand' :thumbnail="$hotSecondhand->thumbnail" :title="$hotSecondhand->sku->model->model_no"
                    :url="$hotSecondhand->refurbed==true ? route('refurb.show',$hotSecondhand) : route('used.show',$hotSecondhand)">
                    <p class="text-xs text-gray-600 font-semibold">{{ $hotSecondhand->sku->memory }} RAM |
                        {{ $hotSecondhand->sku->storage }}GB Storage</p>

                    <p class="text-sm leading-4 text-gray-700 font-semibold">
                        @if ( $hotSecondhand->discount > 0 )
                            <span>Rs. {{ $hotSecondhand->amount - ($hotSecondhand->amount * $hotSecondhand->discount / 100) }}</span>
                        @endif
                        <span class="@if ($hotSecondhand->discount > 0) line-through @endif">Rs. {{ $hotSecondhand->amount }}</span>
                    </p>
                </x-partials._card>
            </div>
        @endforeach
    </x-partials._swiper>
    @endif
</x-home-sections>

{{-- Hot accessory swiper --}}
@if($hotAccessories->count() > 0 )
<x-home-sections header="Hot Accessories" class="mb-4 space-y-4">
    <div class="relative">
        <div class="swiper hotaccessories_swiper_element w-[92vw] sm:w-[85vw] h-72 sm:h-60 !p-[2px]">
            <div class="swiper-wrapper">
                @foreach($hotAccessories as $hotAccessory)
                    <div class="swiper-slide">
                        <x-partials._card :product='$hotAccessory' :thumbnail="$hotAccessory->thumbnail" :title="$hotAccessory->title" :url="route('accessories.show',$hotAccessory)">
                            <p class="text-sm leading-4 text-gray-700 font-semibold">
                                @if ( $hotAccessory->discount > 0 )
                                    <span>Rs. {{ $hotAccessory->amount - ($hotAccessory->amount * $hotAccessory->discount / 100) }}</span>
                                @endif
                                <span class="@if ($hotAccessory->discount > 0) line-through @endif">Rs. {{ $hotAccessory->amount }}</span>
                            </p>
                        </x-partials._card>
                    </div>
                @endforeach
            </div>
        </div>
        <x-eva-arrow-ios-back-outline
            class="!hidden sm:!flex !w-16 !h-16 swiper-button-prev accessories-product-btn-prev
            !-bottom-16 sm:!bottom-auto !top-auto sm:!top-[50%] !left-0 !right-20 mx-auto sm:!right-auto sm:mx-0"/>
        <x-eva-arrow-ios-forward-outline
            class="!hidden sm:!flex !w-16 !h-16 swiper-button-next accessories-product-btn-next
            !-bottom-16 sm:!bottom-auto !top-auto sm:!top-[50%] !left-20 !right-0 mx-auto sm:!left-auto sm:mx-0"/>
    </div>
    @endif
</x-home-sections>

{{-- Hot parts swiper --}}
@if($hotParts->count() > 0 )
<x-home-sections header="Hot Parts" class="mb-4 space-y-4">
    <div class="relative">
        <div class="swiper hotparts_swiper_element w-[92vw] sm:w-[85vw] h-72 sm:h-60 !p-[2px]">
            <div class="swiper-wrapper">
                @foreach($hotParts as $hotPart)
                    <div class="swiper-slide">
                        <x-partials._card :product='$hotPart' :thumbnail="$hotPart->thumbnail" :title="$hotPart->name" :url="route('parts.show',$hotPart)">
                            <p class="text-sm leading-4 text-gray-700 font-semibold">
                                @if ( $hotPart->discount > 0 )
                                    <span>Rs. {{ $hotPart->price - ($hotPart->price * $hotPart->discount / 100) }}</span>
                                @endif
                                <span class="@if ($hotPart->discount > 0) line-through @endif">Rs. {{ $hotPart->price }}</span>
                            </p>
                        </x-partials._card>
                    </div>
                @endforeach
            </div>
        </div>
        <x-eva-arrow-ios-back-outline
            class="!hidden sm:!flex !w-16 !h-16 swiper-button-prev parts-product-btn-prev
            !-bottom-16 sm:!bottom-auto !top-auto sm:!top-[50%] !left-0 !right-20 mx-auto sm:!right-auto sm:mx-0"/>
        <x-eva-arrow-ios-forward-outline
            class="!hidden sm:!flex !w-16 !h-16 swiper-button-next parts-product-btn-next
            !-bottom-16 sm:!bottom-auto !top-auto sm:!top-[50%] !left-20 !right-0 mx-auto sm:!left-auto sm:mx-0"/>
    </div>
    @endif
</x-home-sections>

{{-- Hot machine swiper --}}
@if($hotMachines->count() > 0 )
<x-home-sections header="Hot Tools and Machines" class="mb-4 space-y-4">
    <div class="relative">
        <div class="swiper hotmachine_swiper_element w-[92vw] sm:w-[85vw] h-72 sm:h-60 !p-[2px]">
            <div class="swiper-wrapper">
                @foreach($hotMachines as $hotMachine)
                    <div class="swiper-slide">
                        <x-partials._card :product='$hotMachine' :thumbnail="$hotMachine->thumbnail" :title="$hotMachine->title" :url="route('machine.show',$hotMachine)">
                            <p class="text-sm leading-4 text-gray-700 font-semibold">
                                @if ( $hotMachine->discount > 0 )
                                    <span>Rs. {{ $hotMachine->amount - ($hotMachine->amount * $hotMachine->discount / 100) }}</span>
                                @endif
                                <span class="@if ($hotMachine->discount > 0) line-through @endif">Rs. {{ $hotMachine->amount }}</span>
                            </p>
                        </x-partials._card>
                    </div>
                @endforeach
            </div>
        </div>
        <x-eva-arrow-ios-back-outline
            class="!hidden sm:!flex !w-16 !h-16 swiper-button-prev machine-product-btn-prev
            !-bottom-16 sm:!bottom-auto !top-auto sm:!top-[50%] !left-0 !right-20 mx-auto sm:!right-auto sm:mx-0"/>
        <x-eva-arrow-ios-forward-outline
            class="!hidden sm:!flex !w-16 !h-16 swiper-button-next machine-product-btn-next
            !-bottom-16 sm:!bottom-auto !top-auto sm:!top-[50%] !left-20 !right-0 mx-auto sm:!left-auto sm:mx-0"/>
    </div>
    @endif
</x-home-sections>
