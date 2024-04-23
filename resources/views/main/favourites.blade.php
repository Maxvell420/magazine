<x-layout :styles="$styles" :scripts='$scripts' :title="$title">
    <div class="wrapper">
        <div class="products">
            @foreach($products as $product)
                    <x-products.plate :product="$product" :favourites="$favourites" :token="csrf_token()"/>
            @endforeach
        </div>
    </div>
</x-layout>
