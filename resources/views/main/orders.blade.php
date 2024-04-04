<x-layout :styles="$styles" :title="$title">
    <div class="wrapper">
        <div class="ordersHead">
            <h2>Ваши заказы</h2>
        </div>
        <div class="orders">
            @if($orders->isEmpty())
                <h3>Мы не нашли ваши заказы...</h3>
            @else
                <div class="order">
                    <p>Номер заказа</p>
                    <p>Сумма заказа</p>
                    <p>Статус оплаты</p>
                    <p>Статус заказа</p>
                </div>
                @foreach($orders as $order)
                    <a href="{{route('order.show',[$order])}}">
                        <div class="order">
                            <p>№-{{$order->id}}</p>
                            <p>{{$order->price}} ₽</p>
                            <p>@if($order->payed)
                                    Оплачен
                                @else
                                    Не оплачен
                                @endif
                            </p>
                            <p>{{$order->status}}</p>
                        </div>
                    </a>
                @endforeach
            @endif
        </div>
    </div>
</x-layout>
