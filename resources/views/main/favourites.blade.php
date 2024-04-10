<x-layout :styles="$styles" :scripts="$scripts" :title="$title">
    <div class="wrapper">
        <div class="products">
            @foreach($products as $product)
                <a href="{{route('main.product',$product)}}">
                    <x-products.plate :product="$product" :favourites="$favourites"/>
                </a>
            @endforeach
        </div>
    </div>
</x-layout>
<script defer>
    generateCartButtons()
</script>
