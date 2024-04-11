<x-layout :styles="$styles" :scripts='$scripts' :title="$title">
    <div class="wrapper">
        <div class="products">
            @foreach($products as $product)
                <a href="{{route(trans('routes.names.main.product'),$product)}}">
                    <x-products.plate :product="$product" :favourites="$favourites"/>
                </a>
            @endforeach
        </div>
    </div>
</x-layout>
