<x-layout :styles="$styles" :scripts="$scripts" :title="$title">
    <x-filter.head :categories="$categories" :subcategories="$subcategories"/>
    <div class="dashboardWrapper">
        <x-filter.window :categories:="$categories" :subcategories="$subcategories"/>
        <div class="products">
            @foreach($products as $product )
                <a href="{{route('main.product',$product)}}">
                    <x-products.plate :product="$product" :favourites="$favourites"/>
                </a>
            @endforeach
        </div>
    </div>
</x-layout>
<script defer>
    appendCategoryButton()
    categoryAppend({!! $categories !!},{!! $subcategories !!},{!! $productsProperties !!})
    updateCartValue()
</script>

