<div class="filter">
    <form action="{{route($route)}}">
        <label>
            Город
            <select name="city">
                @foreach($cities as $city)
                    <option value="{{$city->id}}" @if($values['city']==$city->id) selected @endif >{{$city->name}}</option>
                @endforeach
            </select>
        </label>
        <label>
            Количество Комнат
            <input type="range" min="0" max="10" id="rooms" name="rooms" value="{{$values['rooms']??0}}" oninput="updateRooms(this.value)">
            <output for="rooms" id="roomsValue">{{$values['rooms']??0}}</output>
        </label>
        <label>
            Цена
            <input type="range" min="0" max="100000" id="price" name="price" value="{{$values['price']??0}}" oninput="updatePrice(this.value)">
            <output for="price" id="priceValue">{{$values['price']??0}}</output>
        </label>
        <input type="submit">
    </form>
    <div>
        <a href="{{route($route)}}">reset filter</a>
    </div>
</div>
