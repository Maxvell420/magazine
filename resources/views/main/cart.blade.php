<x-layout :styles="$styles" :title="$title">
    <div class="cart">
        <h2>{{trans('form.cart')}}</h2>
        <form class="order" action="{{route(trans('routes.names.main.checkout'))}}">
        @if($products->isEmpty())
            <div>{{trans('form.total')}}: <span id="total">0 ₽</span></div>
        @else
            @foreach($products as $product)
                <div class="product" id="product_{{$product->id}}">
                    <div class="productName">
                        <h3>{{$product->name}}</h3>
                        <button type="button" class="deleteProduct" id="delete_{{$product->id}}"><img src="{{asset('images/buttons/remove-from-cart-icon.svg')}}" alt="remove"></button>
                    </div>
                    <div class="productInfo">
                        <img src="{{asset($product->preview)}}" alt="preview">
                        <input type="hidden" id="{{$product->id}}" name="{{$product->id}}" value="0">
                        <div class="productQuantity">
                            <button type="button" class="quantity" id="minus_{{$product->id}}">-</button>
                            <div class="quantity" id="totalQuantity_{{$product->id}}">0</div>
                            <button type="button" class="quantity" id="plus_{{$product->id}}">+</button>
                        </div>
                        <div class="productTotal">
                            <span id="totalProductPrice_{{$product->id}}">0 ₽</span>
                        </div>
                    </div>
                </div>
                <script defer>ProductEventManager({!! $product !!},@json(trans('form')))</script>
            @endforeach
            <div class="totalWrapper">
                <div id="total">{{trans('form.total')}}: 0 ₽</div>
                <button type="submit" id="submit">{{trans('form.checkout')}}</button>
            </div>
        @endif
        </form>
    </div>
</x-layout>
