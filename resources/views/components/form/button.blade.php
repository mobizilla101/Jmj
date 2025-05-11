@props([
    'type'=>'button',
])

<button type="{{$type}}"
    {{
    $attributes->merge(['class'=>'!bg-blue-400 text-primary-100 font-semibold transition ease-in-out hover:bg-blue-800 px-5 py-3 rounded-md w-full min-h-12 border-2 border-blue-400 hover:border-blue-800'])
    }}
>
{{$slot}}
</button>
