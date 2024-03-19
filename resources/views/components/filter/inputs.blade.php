<label for="city"><span>Город:</span>
    <select id="city" name="city">
        <option value="0" selected>Любой</option>
        @foreach($cities as $city)
            <option value="{{$city->id}}" @if($values['city']==$city->id) selected @endif >{{$city->name}}</option>
        @endforeach
    </select>
</label>
<label for="price"><span>Цена (руб):</span>
    <input type="number" id="price" min="1" name="price" value="{{$values['price']??old('price')}}" placeholder="Цена">
</label>
<label for="rooms">
    <span>Комнат:</span>
    <input type="number" id="rooms" name="rooms" value="{{$values['rooms']??old('rooms')}}" placeholder="Число комнат">
</label>


<label for="fridge">
    <span>Холодильник:</span>
    <input type="checkbox" id="fridge" name="fridge" value="1" @if($values['fridge']==1) checked @endif>
</label>

<label for="dishwasher">
    <span>Посудомойка:</span>
    <input type="checkbox" id="dishwasher" name="dishwasher" value="1" @if($values['dishwasher']==1) checked @endif>
</label>

<label for="clothWasher">
    <span>Стиралка:</span>
    <input type="checkbox" id="clothWasher" name="clothWasher" value="1" @if($values['clothWasher']==1) checked @endif>
</label>

<label for="balcony">
    <span>Балкон:</span>
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
</label>

<label for="bathroom">
    <span>Санузел:</span>
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
</label>

<label for="author">
    <span>Кто разместил:</span>
    <select id="author" name="author">
        <option value="1" @if($values['author']==1) selected @endif>
            Владелец
        </option>
        <option value="2" @if($values['author']==2) selected @endif>
            Агенство
        </option>
    </select>
</label>
