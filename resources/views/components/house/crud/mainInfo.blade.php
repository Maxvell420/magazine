<div>
    <h3>Основная Информация</h3>
    <label>
        Заголовок:
        <input type="text" name="title" placeholder="Заголовок" value="{{old('title')}}">
    </label>
    <label>
        Цена:
        <input type="number" min="1" name="price" value="{{old('price')}}" required placeholder="Цена">
    </label>
    <label>
        Город:
        <input type="text" name="city" value="{{old('city')}}" placeholder="Город">
    </label>
    <label>
        Улица:
        <input type="text" name="street" value="{{old('street')}}" placeholder="Улица">
    </label>
    <label>
        Здание:
        <input type="text" name="building" value="{{old('building')}}" placeholder="Здание">
    </label>
</div>
