<x-layout :styles="$styles" :scripts="$scripts" :title="$title">
    <x-adminHeader/>
    <div class="wrapper">
        <div class="search">
            <label for="order">Поиск заказа</label>
            <input id="order" type="text" name="order" placeholder="Номер заказа" autocomplete="off">
        </div>
        <div class="results">
            <div class="resultHead">
                <p>Номер заказа</p>
                <p>Сумма заказа (₽)</p>
                <p>Статус оплаты</p>
                <p>Статус заказа</p>
            </div>
            <div class="searchOrders">
                @foreach($newOrders as $order)
                    <a href="{{route('order.show',[$order])}}" class="order">
                            <p>{{$order->id}}</p>
                            <p>{{$order->price}}</p>
                            <p>@if($order->payed)
                                    Оплачен
                                @else
                                    Не оплачен
                                @endif
                            </p>
                            <p>{{$order->status}}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-layout>
<script defer>
    adminkaEventManager({!! $orders !!})
</script>
