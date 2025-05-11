<section {{ $attributes->merge(['class'=>'mx-auto px-4 py-6 sm:px-6 lg:py-8 lg:px-8']) }}>
    <div class="sm:pe-6 lg:pe-8 xl:ps-4">
        <h2 class="text-4xl font-bold tracking-tight text-primary-300 sm:text-5xl text-center">
            {{ $header }}
        </h2>
    </div>

    {{ $slot }}
</section>
