@props([
    "trending_products"=>[]
    ])

<div class="grid grid-rows-2 grid-cols-2 mt-4 gap-4">
    @foreach ($trending_products as $trending_product)
        <x-partials._card :product="$trending_product" :thumbnail="$trending_product->thumbnail"
            :title="$trending_product->model_no" :url="route('product.show',$trending_product)">
            @php
                $skuDetail = $trending_product->getConfiguration();
            @endphp

            @empty(!$skuDetail)
                <p class="text-xs text-gray-600 font-semibold">{{ $skuDetail['memory'] }} RAM |
                    {{ $skuDetail['storage'] }}GB Storage</p>

                <p class="text-sm leading-4 text-gray-700 font-semibold">
                    @if ( $skuDetail->discount > 0 )
                        <span>{{$settings['currency'] ?? 'Rs '}}. {{ $skuDetail->price - ($skuDetail->price * $skuDetail->discount / 100) }}</span>
                    @endif
                    <span class="@if ($skuDetail->discount > 0) line-through @endif">{{$settings['currency'] ?? 'Rs '}}. {{ $skuDetail->price }}</span>
                </p>
            @else
                <p class="text-sm leading-4 text-gray-500">
                    No details available
                </p>
            @endempty
        </x-partials._card>
    @endforeach
</div>
