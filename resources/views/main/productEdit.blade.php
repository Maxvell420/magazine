<x-layout :styles="$styles" :scripts="$scripts" :title="$title">
    <div class="wrapper">
        <form action="{{route('product.edit',$product)}}">
            <div class="productInfo">
                <h3>Информация о товаре</h3>
                <label for="name">Имя продукта:</label>
                <input id="name" type="text" required name="name" placeholder="Название продукта" value="{{old('name')??$product->name}}">
                <label for="price">Цена продукта:</label>
                <input id="price" type="number" min="1" required step="1" name="price" placeholder="Цена продукта" value="{{old('price')??$product->price}}">
                <label for="quantity">Количество товаров:</label>
                <input id="quantity" type="number" min="0" step="1" required name="quantity" placeholder="Количество товаров" value="{{old('quantity')??$product->quantity}}">
            </div>
            <div class="additionalInfo">
                <h3>Характеристики товара</h3>
                {{--Слабое место что при валидации свойста которые сделал пользователь не сохранятся из-за того что имя textarea динамически формируется в js--}}
                @foreach($properties as $key => $value)
                    <div class="property">
                        <label for="{{$key}}">Название свойства:</label>
                        <input id="{{$key}}" value="{{$key}}">
                        <label for="{{$value}}">Описание:</label>
                        <textarea id="{{$value}}" name="{{$key}}">{{$value}}</textarea>
                        <button type="button">Удалить свойство</button>
                    </div>
                @endforeach
            </div>
            <div>
                <button type="button" id="more">Добавить еще свойство</button>
                <button type="submit" id="save">Сохранить</button>
            </div>
        </form>
    </div>
</x-layout>
