<div>
    <h3>Дополнительная информация</h3>
    <label>
        Комнат:
        <input type="number" name="rooms" value="{{old('rooms')}}" placeholder="rooms">
    </label>
    <label>
        Метро:
        <input type="text" name="metro" value="{{old('metro')}}" placeholder="Остановка метро">
    </label>
    <label>
        Холодильник:
        <input type="checkbox" name="fridge" value="1">
    </label>
    <label>
        Посудомоечная Машина:
        <input type="checkbox" name="dishwasher" value="1">
    </label>
    <label>
        Стиральная Машина:
        <input type="checkbox" name="clothWasher" value="1">
    </label>
    <label>
        Балкон:
        <select name="balcony">
            <option value="0" selected>
                Нет
            </option>
            <option value="1">
                Лоджия
            </option>
            <option value="2">
                балкон
            </option>
            <option value="3">
                Несколько балконов
            </option>
        </select>
    </label>
    <label>
        Санузлы:
        <select name="bathroom">
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
    </label>
    <label>
        Залог (руб):
        <input type="number" name="pledge">
    </label>
    <label>
        Кто разместил:
        <select name="author">
            <option value="1">Владелец</option>
            <option value="2">Агенство</option>
        </select>
    </label>
    <label>
        Инфраструктура:
        <textarea name="infrastructure" placeholder="Инфраструктура">{{old('infrastructure')}}</textarea>
    </label>
    <label>
        Описание:
        <textarea name="description" placeholder="Описание">{{old('description')}}</textarea>
    </label>
</div>
