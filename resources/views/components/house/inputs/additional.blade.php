<label for="metro">Метро:</label>
<input type="text" id="metro" name="metro" value="{{old('metro')}}" placeholder="Остановка метро">

<label for="rooms">Комнат:</label>
<input type="number" id="rooms" name="rooms" value="{{old('rooms')}}" placeholder="Число комнат">


<label for="fridge">Холодильник:</label>
<input type="checkbox" id="fridge" name="fridge" value="1">

<label for="dishwasher">Посудомойка:</label>
<input type="checkbox" id="dishwasher" name="dishwasher" value="1">

<label for="clothWasher">Стиралка:</label>
<input type="checkbox" id="clothWasher" name="clothWasher" value="1">
<label for="balcony">Балкон:</label>
<select id="balcony" name="balcony">
    <option value="0">
        Нет
    </option>
    <option value="1">
        Лоджия
    </option>
    <option value="2">
        Балкон
    </option>
    <option value="3">
        Несколько балконов
    </option>
</select>

<label for="bathroom">Санузел:</label>
<select id="bathroom" name="bathroom">
    <option value="1">
        Совмещенный
    </option>
    <option value="2">
        Раздельный
    </option>
    <option value="3">
        2 и более
    </option>
</select>

<label for="author">Кто разместил:</label>
<select id="author" name="author">
    <option value="1">
        Владелец
    </option>
    <option value="2">
        Агенство
    </option>
</select>
