<section class="row-start-2 md:row-start-1 h-full">
    <header class="text-xl font-semibold mb-4">Key Specifications</header>

    <div class="space-y-4">
        @foreach (config('key_specifications') as $key => $specs)
            @if ($key === 'camera')
                @if (array_filter($specs['keys'], fn($key) => $product[$key . '_active'] ?? false))
                    <div class="flex gap-4 items-center">
                        <div>
                            @svg($specs['svg'], 'w-10 h-10')
                        </div>

                        <div>
                            <header class="font-semibold text-base">{{ ucwords(str_replace('_', ' ', $key)) }}</header>
                            @foreach ($specs['keys'] as $cameraKey)
                                @if ($product[$cameraKey . '_active'])
                                    <p class="text-base text-primary-300">{{ $product[$cameraKey . '_specification'] }}</p>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            @elseif ($product[$key . '_active'])
                <div class="flex gap-4 items-center">
                    <div>
                        @svg($specs['svg'], 'w-10 h-10')
                    </div>

                    <div>
                        <header class="font-semibold text-base">{{ ucwords(str_replace('_', ' ', $key)) }}</header>
                        <p class="text-base text-primary-300">{{ $product[$key . '_specification'] }}</p>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</section>
