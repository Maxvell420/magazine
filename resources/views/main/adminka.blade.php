<x-layout :styles="$styles" :scripts="$scripts" :title="$title">
    <x-adminHeader/>
    <div class="wrapper">
        <div class="search">
            <label for="order">{{trans('order.search')}}</label>
            <input id="order" type="text" name="order" placeholder="{{trans('order.id')}}" autocomplete="off">
        </div>
        <div class="results">
            <div class="resultHead">
                <p>{{trans('order.id')}}</p>
                <p>{{trans('order.price')}}(₽)</p>
                <p>{{trans('order.payment')}}</p>
                <p>{{trans('order.status')}}</p>
            </div>
            <div class="searchOrders">
                @foreach($newOrders as $order)
                    <a href="{{route(trans('routes.names.order.show'),[$order])}}" class="order">
                        <p>{{$order->id}}</p>
                        <p>{{$order->price}}</p>
                        <p>{{trans("order.payed.{$order->payed}")}}</p>
                        <p>{{trans("order.orderStatus.$order->status")}}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-layout>
<script defer>
    adminkaEventManager({!! $orders !!},@json(trans('order')))
</script>
