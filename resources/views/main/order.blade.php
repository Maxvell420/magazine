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
        </div>
    </div>
</x-layout>
