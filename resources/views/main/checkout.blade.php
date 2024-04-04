<x-layout :styles="$styles" :scripts="$scripts" :title="$title">
    <form action="{{route('order.save')}}" method="post">
        @csrf
        <div class="order">
            <h3>Оформление заказа</h3>
            @guest
                <div class="warning">
                    Настоятельно рекомендуем вам авторизоваться
                </div>
            @endguest
            <div class="products">
                <div class="product">
                    <div class="productInfo">
                        <p>Название продукта</p>
                        <p>Количество</p>
                        <p>Стоимость (₽)</p>
                    </div>
                </div>
                @foreach($products as $product)
                    <div class="product">
                        <input type="hidden" name="{{$product->id}}" value="{{$product->total_quantity}}">
                        <div class="productInfo">
                            <p>{{$product->name}}</p>
                            <p>{{$product->total_quantity}}</p>
                            <p>{{$product->total_price}}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="orderInfo">
                <div class="delivery">
                    <label for="pickup">Самовывоз</label>
                    <input id="pickup" name="delivery" type="radio" checked value="1" autocomplete="off">
                    <label for="courier">Курьер</label>
                    <input id="courier" name="delivery" type="radio" value="2" autocomplete="off" >
                </div>
                <div class="confirmation">
                    <div class="productsPrice">
                        {{$totalPrice}} ₽
                    </div>
                    <div class="deliveryPrice">
                        0 ₽
                    </div>
                    <div class="totalPrice">
                        {{$totalPrice}} ₽
                    </div>
                </div>
                <button type="submit">Подтвердить</button>
            </div>
        </div>
    </form>
</x-layout>
<script defer>OrderEventManager({!! $deliveries !!})</script>
