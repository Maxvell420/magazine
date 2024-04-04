<x-layout :styles="$styles" :scripts="$scripts" :title="$title">
    <div class="cart">
        <h2>Корзина</h2>
        <form class="order" action="{{route('main.checkout')}}" method="post">
        @if($products->isEmpty())
            <div>Итого:<span id="total">0 ₽</span></div>
        @else
            @csrf
            @foreach($products as $product)
                <div class="product" id="product_{{$product->id}}">
                    <div class="productName">
                        <h3>{{$product->name}}</h3>
                        <button type="button" class="deleteProduct" id="delete_{{$product->id}}"><img src="{{asset('images/buttons/remove-from-cart-icon.svg')}}" alt="remove"></button>
                    </div>
                    <div class="productInfo">
                        <img src="{{$product->preview}}" alt="preview">
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
                <script defer>ProductEventManager({!! $product !!})</script>
            @endforeach
            <div class="totalWrapper">
                <div id="total">Итого: 0 ₽</div>
                <button type="submit" id="submit">Оформить</button>
            </div>
        @endif
        </form>
    </div>
</x-layout>
