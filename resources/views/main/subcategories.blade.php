<x-layout :styles="$styles" :title="$title">
    <x-adminHeader/>
    <div class="wrapper">
        <h3>{{trans('subcategory.subcategories')}}</h3>
        <div class="subcategories">
            @foreach($subcategories as $subcategory)
                <x-subcategory :subcategory="$subcategory"/>
            @endforeach
        </div>
    </div>
</x-layout>
