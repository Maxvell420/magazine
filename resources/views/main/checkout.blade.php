<x-layout :styles="$styles" :scripts="$scripts" :title="$title">
    <form action="{{route(trans('routes.names.order.save'))}}" method="post">
        @csrf
        <div class="order">
            <h3>{{trans('order.create')}}</h3>
            @guest
                <div class="warning">
                    {{trans('message.auth.warning')}}
                </div>
            @endguest
            <div class="products">
                <div class="product">
                    <div class="productInfo">
                        <p>{{trans('product.name')}}</p>
                        <p>{{trans('product.quantity')}}</p>
                        <p>(₽) {{trans('product.price')}}</p>
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
                    <label for="pickup">{{trans('form.pickup')}}</label>
                    <input id="pickup" name="delivery" type="radio" checked value="1" autocomplete="off">
                    <label for="courier">{{trans('form.delivery')}}</label>
                    <input id="courier" name="delivery" type="radio" value="2" autocomplete="off" >
                </div>
                <div class="confirmation">
                    <div class="productsPrice">
                        {{trans('product.price')}} {{$totalPrice}} ₽
                    </div>
                    <div class="deliveryPrice">
                        {{trans('form.delivery')}}: 0 ₽
                    </div>
                    <div class="totalPrice">
                        {{trans('form.total')}}: {{$totalPrice}} ₽
                    </div>
                </div>
                <button type="submit">{{trans('order.create')}}</button>
            </div>
        </div>
    </form>
</x-layout>
<script defer>OrderEventManager({!! $deliveries !!})</script>
