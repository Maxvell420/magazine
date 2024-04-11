<x-layout :styles="$styles" :scripts="$scripts" :title="$title">
    <div class="wrapper">
        @if (session('warning'))
            <div class="alert alert-warning">
                {{ session('warning') }}
            </div>
        @endif
        <h2>{{trans('product.edit')}}: {{$product->name}}</h2>
        <form action="{{route(trans('routes.names.product.update'),$product)}}" method="post">
            @csrf
            <h3>{{trans('product.info')}}</h3>
            <div class="productInfo">
                <label for="name">{{trans('product.name')}}</label>
                <input id="name" type="text" required name="name" placeholder="Название продукта" value="{{old('name')??$product->name}}">
                <label for="price">{{trans('product.price')}}</label>
                <input id="price" type="number" min="1" required step="1" name="price" placeholder="Цена продукта" value="{{old('price')??$product->price}}">
                <label for="quantity">{{trans('product.quantity')}}</label>
                <input id="quantity" type="number" min="0" step="1" required name="quantity" placeholder="Количество товаров" value="{{old('quantity')??$product->quantity}}">
            </div>
            <h3>{{trans('product.characteristics')}}</h3>
            <div class="additionalInfo">
                {{--Слабое место что при валидации свойста которые сделал пользователь не сохранятся из-за того что имя textarea динамически формируется в js--}}
                @foreach($properties as $key => $value)
                    <div class="property">
                        <label for="{{$key}}">Название свойства:</label>
                        <input id="{{$key}}" value="{{$key}}">
                        <label for="{{$value}}">Описание:</label>
                        <textarea id="{{$value}}" name="{{$key}}">{{$value}}</textarea>
                        <div></div>
                        <div class="button">
                            <button type="button">Удалить свойство</button>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="button">
                <button type="button" id="more">Добавить еще свойство</button>
                <button type="submit" id="save">Сохранить</button>
            </div>
        </form>
    </div>
</x-layout>
<script defer>
    productEditEventManager()
</script>
