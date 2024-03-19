<div class="houseMainForm">
    <label for="title">Заголовок:</label>
    <input type="text" id="title" name="title" placeholder="Заголовок" value="{{old('title')}}">
    <label for="price">Цена:</label>
    <input type="number" id="price" min="1" name="price" value="{{old('price')}}" required placeholder="Цена">
    <label for="city">Город:</label>
    <input type="text" id="city" name="city" value="{{old('city')}}" placeholder="Город">
    <label for="street">Улица:</label>
    <input type="text" id="street" name="street" value="{{old('street')}}" placeholder="Улица">
    <label for="building">Номер дома:</label>
    <input type="text" id="building" name="building" value="{{old('building')}}" placeholder="Номер дома">
</div>
