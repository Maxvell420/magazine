<x-layout :styles="$styles" :title="$title">
    <x-adminHeader/>
    <div class="wrapper">
        <h3>{{trans('category.categories')}}</h3>
        <div class="categories">
            @foreach($categories as $category)
                <x-category :category="$category"/>
            @endforeach
        </div>
    </div>
</x-layout>
