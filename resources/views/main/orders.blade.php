<x-layout :styles="$styles" :title="$title">
    <div class="wrapper">
        <div class="ordersHead">
            <h2>{{trans('order.orders')}}</h2>
        </div>
        <div class="orders">
            @if($orders->isEmpty())
                <h3>{{trans('order.none')}}</h3>
            @else
                <div class="order">
                    <p>{{trans('order.id')}}</p>
                    <p>{{trans('order.price')}}</p>
                    <p>{{trans('order.payment')}}</p>
                    <p>{{trans('order.status')}}</p>
                </div>
                @foreach($orders as $order)
                    <a href="{{route(trans('routes.names.order.show'),[$order])}}">
                        <div class="order">
                            <p>№-{{$order->id}}</p>
                            <p>{{$order->price}} ₽</p>
                            <p>{{trans("order.payed.$order->payed")}}</p>
                            <p>{{trans("order.orderStatus.$order->status")}}</p>
                        </div>
                    </a>
                @endforeach
            @endif
        </div>
    </div>
</x-layout>
