<x-layout :styles="$styles" :title="$title">
    <div class="wrapper">
        @guest
            <div class="warning">
                Настоятельно рекомендуем вам сохранить номер вашего заказа и загрузить файл заказа
            </div>
        @endguest
        <div class="order">
            <div class="orderHeader">
                <h3>Заказ№-{{$order->id}}</h3>
                <div class="file"><a href="{{asset($filepath)}}">Скачать заказ</a></div>
            </div>
            <div class="products">
                <p>Название продукта</p>
                <p>Количество</p>
                <p>Стоимость (₽)</p>
                @foreach($products as $product)
                    <p>{{$product->name}}</p>
                    <p>{{$product->total_quantity}}</p>
                    <p>{{$product->total_price}}</p>
                @endforeach
                @if($delivery->id>1)
                    <p>Доставка</p>
                    <p>1</p>
                    <p>{{$delivery->price}}</p>
                @endif
                <p>Итого:</p>
                <p>{{$orderQuantity}}</p>
                <p>{{$order->price}}</p>
            </div>
            <div class="orderStatus">
                <p>Статус заказа</p>
                <p>Статус оплаты</p>
                <p>{{$order->status}}</p>
                @if($order->payed)
                    <p>Оплачен</p>
                @else
                    <p>Не Оплачен</p>
                   @endif
            </div>
            @auth
            @if(\Illuminate\Support\Facades\Auth::user()->role_id>1)
                <form action="{{route('order.edit',[$order])     }}" method="post" class="orderEdit">
                    @csrf
                    <label for="payment">Изменить статус оплаты заказа:</label>
                    <select id="payment" name="payed">
                        <option @if(!$order->payed) selected @endif value="0">Не оплачен</option>
                        <option @if($order->payed) selected @endif value="1">Оплачен</option>
                    </select>
                    <label for="status">Изменить статус оплаты</label>
                    <select id="status" name="status">
                        <option @if($order->status == 'Подготовка заказа') selected @endif>Подготовка заказа</option>
                        <option @if($order->status == 'Готов к получению') selected @endif>Готов к получению</option>
                    </select>
                    <div></div>
                    <button type="submit">Сохранить изменения</button>
                </form>
                       @endif
            @endauth
        </div>
    </div>
</x-layout>
