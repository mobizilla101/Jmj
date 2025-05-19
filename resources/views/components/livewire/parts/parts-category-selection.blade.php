@php

    $model_id = $this->selectedModelId;
    $partsCategories = \App\Models\PartsCategory::whereHas('parts',function($query) use ($model_id){
        $query->where('parts.model_id',$model_id)->where('parts.published',true);
    })->get();
    $model = \App\Models\Model::where('id', $model_id)->first();

@endphp
<div x-show="showModal" class="parts__category__wrapper"
     @click.outside="$wire.deselectModel()">
    <header class="capitalize font-semibold text-sm mb-12 sm:text-2xl text-center text-primary-300">
        Pick your part
    </header>
{{--    For tablet and desktop--}}
    <div class="relative w-full parts__category__animation__wrapper" data-show="{{$this->showModal}}">
        @foreach($parts as $key => $part)
            @php
                $index = $key +1;
                $category = $partsCategories->firstWhere('parts_category', $index);
                $category_id = $category ? $category->id : null;
                $category_name = $category ? $category->name:null
            @endphp
            @if($category)
                <div
                    data-order="{{$index}}">
                    <span data-order="{{$index}}"></span>
                    <a
                        href="{{route('parts.category',['brand'=>$model->brand_id,'model'=>$this->selectedModelId,'category'=>$category_id])}}"
                        class="absolute bg-blue-400 text-white py-2 px-4 w-max text-sm rounded-full"
                        data-order="{{$index}}">{{$category_name}}</a>
                    <img src="{{$part['url']}}" alt="{{$index}}" lazy="true"
                         x-on:click="window.location.href='{{route('parts.category',['brand'=>$model->brand_id,'model'=>$this->selectedModelId,'category'=>$category_id])}}'"/>
                </div>
            @else
                <img src="{{$part['url']}}" alt="{{$index}}" data-order="{{$index}}" lazy="true"/>
            @endif
        @endforeach
    </div>
{{--    For Mobile--}}
    <div class="relative w-full -mt-12 parts__category__mobile__animation__wrapper" data-show="{{$this->showModal}}">
        @foreach($parts as $key => $part)
            @php
                $index = $key +1;
                $category = $partsCategories->firstWhere('parts_category', $index);
                $category_id = $category ? $category->id : null;
                $category_name = $category ? $category->name:null
            @endphp
            @if($category)
                <div
                    data-order="{{$index}}">
                    <span data-order="{{$index}}"></span>
                    <a
                        href="{{route('parts.category',['brand'=>$model->brand_id,'model'=>$this->selectedModelId,'category'=>$category_id])}}"
                        class="absolute bg-blue-400 text-white py-2 px-4 w-max text-sm rounded-full"
                        data-order="{{$index}}">{{$category_name}}</a>
                    <img src="{{$part['url']}}" alt="{{$index}}" lazy="true"
                         x-on:click="window.location.href='{{route('parts.category',['brand'=>$model->brand_id,'model'=>$this->selectedModelId,'category'=>$category_id])}}'"/>
                </div>
            @else
                <img src="{{$part['url']}}" alt="{{$index}}" data-order="{{$index}}" lazy="true"/>
            @endif
        @endforeach
    </div>
</div>
