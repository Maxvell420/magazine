<label for="city">Город:</label>
<select id="city" name="city">
    <option value="0" selected>Любой</option>
    @foreach($cities as $city)
        <option value="{{$city->id}}" @if($values['city']==$city->id) selected @endif >{{$city->name}}</option>
    @endforeach
</select>
<label for="price">Цена (руб):</label>
<input type="number" id="price" min="1" name="price" value="{{$values['price']??old('price')}}" placeholder="Цена">
<label for="rooms">Комнат:</label>
<input type="number" id="rooms" name="rooms" value="{{$values['rooms']??old('rooms')}}" placeholder="Число комнат">


<label for="fridge">Холодильник:</label>
<input type="checkbox" id="fridge" name="fridge" value="1" @if($values['fridge']==1) checked @endif>

<label for="dishwasher">Посудомойка:</label>
<input type="checkbox" id="dishwasher" name="dishwasher" value="1" @if($values['dishwasher']==1) checked @endif>

<label for="clothWasher">Стиралка:</label>

<input type="checkbox" id="clothWasher" name="clothWasher" value="1" @if($values['clothWasher']==1) checked @endif>
<label for="balcony">Балкон:</label>
<select id="balcony" name="balcony">
    <option value="0" @if($values['balcony']==0) selected @endif>
        Нет
    </option>
    <option value="1" @if($values['balcony']==1) selected @endif>
        Лоджия
    </option>
    <option value="2" @if($values['balcony']==2) selected @endif>
        Балкон
    </option>
    <option value="3" @if($values['balcony']==3) selected @endif>
        Несколько балконов
    </option>
</select>

<label for="bathroom">Санузел:</label>
<select id="bathroom" name="bathroom">
    <option value="0" @if($values['bathroom']==1) selected @endif>
        Любой
    </option>
    <option value="1" @if($values['bathroom']==1) selected @endif>
        Совмещенный
    </option>
    <option value="2" @if($values['bathroom']==2) selected @endif>
        Раздельный
    </option>
    <option value="3" @if($values['bathroom']==3) selected @endif>
        2 и более
    </option>
</select>

<label for="author">Кто разместил:</label>
<select id="author" name="author">
    <option value="1" @if($values['author']==1) selected @endif>
        Владелец
    </option>
    <option value="2" @if($values['author']==2) selected @endif>
        Агенство
    </option>
</select>
