<h3>Проверьте корректность:</h3>
<div class="houseMainForm">
     <label for="title">Заголовок:</label>
     <input type="text" id="title" name="title" placeholder="Заголовок" value="{{$validated['title']??old('title')}}">

     <label for="price">Цена:</label>
     <input type="number" id="price" min="1" name="price" value="{{$validated['price']??old('price')}}" required placeholder="Цена">

     <label for="rooms">Комнат:</label>
     <input type="number" id="rooms" name="rooms" value="{{$validated['rooms']??old('rooms')}}" placeholder="rooms">

     <label for="metro">Метро:</label>
     <input type="text" id="metro" name="metro" value="{{$validated['metro']??old('metro')}}" placeholder="Остановка метро">

     <label for="fridge">Холодильник:</label>
     <input type="checkbox" id="fridge" name="fridge" value="1" @if(!empty($validated['fridge'])) checked @endif {{ old('fridge') ? 'checked' : '' }}>

     <label for="dishwasher">Посудомоечная Машина:</label>
     <input type="checkbox" id="dishwasher" name="dishwasher" value="1" @if(!empty($validated['dishwasher'])) checked @endif {{ old('dishwasher') ? 'checked' : '' }}>

     <label for="clothWasher">Стиральная Машина:</label>
         <input type="checkbox" id="clothWasher" name="clothWasher" value="1" @if(!empty($validated['clothWasher']))checked @endif {{ old('clothWasher') ? 'checked' : '' }}>
     <label for="balcony">Балкон:</label>
     <select id="balcony" name="balcony">
        <option value="0" @if($validated['balcony']===0) selected @endif>
            Нет
        </option>
        <option value="1" @if($validated['balcony']===1) selected @endif>
            Лоджия
        </option>
        <option value="2" @if($validated['balcony']===2) selected @endif>
            Балкон
        </option>
        <option value="3" @if($validated['balcony']===3) selected @endif>
            Несколько балконов
        </option>
     </select>

     <label for="bathroom">Санузлы:</label>
     <select id="bathroom" name="bathroom">
         <option value="1" @if($validated['bathroom']===1) selected @endif>
             Совмещенный
         </option>
         <option value="2" @if($validated['bathroom']===2) selected @endif>
             Раздельный
         </option>
         <option value="3" @if($validated['bathroom']===3) selected @endif>
             2 и более
         </option>
     </select>

     <label for="author">Кто разместил:</label>
     <select id="author" name="author">
         <option value="1" @if($validated['author']===1) selected @endif>
             Владелец
         </option>
         <option value="2" @if($validated['author']===2) selected @endif>
             Агенство
         </option>
     </select>

     <label for="pledge">Залог (руб):</label>
     <input type="number" id="pledge" name="pledge" value="{{$validated['pledge']??old('pledge')}}">

     <label for="infrastructure">Инфраструктура:</label>
     <textarea name="infrastructure" id="infrastructure" placeholder="Инфраструктура">{{$validated['infrastructure']??old('infrastructure')}}</textarea>

     <label for="description">Описание:</label>
     <textarea name="description" id="description" placeholder="Описание">{{$validated['description']??old('description')}}</textarea>
</div>
