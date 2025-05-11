@props([
    'label'=> null,
    'name' => 'example',
    'id' => null,
    'value' => '',
    'labelClass' => '',
    'labelStyle' => '',
    'inputClass' => ''
    ])
<div {{$attributes->merge(['class'=>'mb-4'])}}>
    <label
    for="{{$id}}"
    class="block text-primary-300 font-semibold {{$labelClass}}"
    style="{{$labelStyle}}"
    >{{ucfirst(__($label ?? $value))}}</label>
    <input
        type="radio"
        name="{{$name}}"
        value="{{$value}}"
        id="{{$id}}"
        class="{{$inputClass}}"
    >
</div>
