<x-layout :styles="$styles" :title="$title">
    <div class="wrapper">
        @guest
            <div class="warning">
                {{trans('messages.auth.warning')}}
            </div>
        @endguest
        <div class="order">
            <div class="orderHeader">
                <h3>{{trans('order.order')}}:{{$order->id}}</h3>
                <div class="file"><a href="{{asset($filepath)}}">{{trans('order.download')}}</a></div>
            </div>
            <div class="products">
                <p>{{trans('product.name')}}</p>
                <p>{{trans('product.quantity')}}</p>
                <p>{{trans('product.price')}}(₽)</p>
                @foreach($products as $product)
                    <p>{{$product->name}}</p>
                    <p>{{$product->total_quantity}}</p>
                    <p>{{$product->total_price}}</p>
                @endforeach
                @if($delivery->id>1)
                    <p>{{trans('form.delivery')}}</p>
                    <p>1</p>
                    <p>{{$delivery->price}}</p>
                @endif
                <p>{{trans('form.total')}}</p>
                <p>{{$orderQuantity}}</p>
                <p>{{$order->price}}</p>
            </div>
            <div class="orderStatus">
                <p>{{trans('order.status')}}</p>
                <p>{{trans('order.payment')}}</p>
                <p>{{trans("order.orderStatus.$order->status")}}</p>
                <p>{{trans("order.payed.$order->payed")}}</p>
            </div>
            @auth
                @if(\Illuminate\Support\Facades\Auth::user()->role_id>1)
                    <form action="{{route(trans('routes.names.order.edit'),[$order])}}" method="post" class="orderEdit">
                        @csrf
                        <label for="payment">{{trans('order.changePayment')}}</label>
                        <select id="payment" name="payed">
                            <option @if(!$order->payed) selected @endif value="0">{{trans('order.payed.0')}}</option>
                            <option @if($order->payed) selected @endif value="1">{{trans('order.payed.1')}}</option>
                        </select>
                        <label for="status">{{trans('order.changeStatus')}}</label>
                        <select id="status" name="status">
                            <option @if($order->status == 0) selected @endif>{{trans('order.orderStatus.0')}}</option>
                            <option @if($order->status == 1) selected @endif>{{trans('order.orderStatus.1')}}</option>
                        </select>
                        <div></div>
                        <button type="submit">{{trans('form.save')}}</button>
                    </form>
                @endif
            @endauth
        </div>
    </div>
</x-layout>
