@props([
    'hoverLine'=>false,
    'route'=>route('home')
    ])
<a href="{{ $route }}"
    {{ $attributes->merge([
        'class' => "
         relative
         inline-block
         px-6
         py-2
         text-primary-100
         font-semibold transition
         duration-300
         ease-in-out
         ".(
         $hoverLine?"
         lg:after:content-['']
         lg:after:absolute
         lg:after:bottom-0
         lg:after:left-1/2
         lg:after:w-0
         lg:after:h-[2px]
         lg:after:bg-green-800
         lg:after:transform
         lg:after:-translate-x-1/2
         lg:hover:after:w-full
         lg:hover:after:transition-all
         lg:hover:after:duration-300
         ":"").
         "
         hover:text-blue-400
         hover:bg-primary-100
         "
    ]) }}>
    {!! ucfirst($slot) !!}
</a>
