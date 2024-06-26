<x-layout :styles="$styles" :title="$title">
    <x-filter.head :categories="$categories" :subcategories="$subcategories"/>
    <h3 class="dashboardHead">{{trans('routes.titles.main.dashboard')}}</h3>
    <div class="dashboardWrapper">
        <x-filter.window :categories:="$categories" :subcategories="$subcategories"/>
        <div class="products">
            @foreach($products as $product )
                <x-products.plate :product="$product" :favourites="$favourites" :token="csrf_token()" />
            @endforeach
        </div>
    </div>
</x-layout>
<script defer>
    appendCategoryButton(@json(trans('category.categories')))
    categoryAppend({!! $categories !!},{!! $subcategories !!},{!! $productsProperties !!})
</script>
<script>
    createAjaxProductsButton("{{route(trans('routes.names.main.ajaxDashboard'))}}","{{trans('routes.texts.main.ajaxDashboard')}}")
</script>
