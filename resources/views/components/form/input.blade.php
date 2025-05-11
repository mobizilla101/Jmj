@props([
    'type'=> 'text',
    'label'=> 'Label',
    'name' => 'example',
    'id'=>null,
    'placeholder'=>'',
    'transparentInput'=>true
    ])
<div {{$attributes->merge(['class'=>'mb-4'])}}>
    <label for="{{$id ?? $name}}" class="block mb-3 text-primary-300 font-semibold">{{ucfirst(__($label))}}</label>
    <input
        type="{{$type}}"
        placeholder="{{$placeholder}}"
        name="{{$name}}"
        value="{{old($name)}}"
        autocomplete="{{$name}}"
        id="{{$id ?? $name}}"
        class="w-full px-3 py-2 border border-blue-400 rounded-md shadow-sm hover:border-opacity-75 focus:outline-none hover:ring-2 hover:ring-blue-400 ease-in-out transition focus:ring-2 focus:ring-blue-400 font-semibold {{$transparentInput?"bg-transparent text-blue-400":"bg-white text-primary-300"}}"
    >
    @error($name)
    <span class="text-xs text-red-500 mt-4" role="alert">
                                        <strong>{{ __($message) }}</strong>
                                    </span>
    @enderror
</div>
