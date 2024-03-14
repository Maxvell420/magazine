 <label>
     Проверьте корректность:
     <label>
         Заголовок:
         <input type="text" name="title" placeholder="Заголовок" value="{{$validated['title']??old('title')}}">
     </label>
     <label>
         Цена:
         <input type="number" min="1" name="price" value="{{$validated['price']??old('price')}}" required placeholder="Цена">
     </label>
     <label>
         Комнат:
         <input type="number" name="rooms" value="{{$validated['rooms']??old('rooms')}}" placeholder="rooms">
     </label>
     <label>
         Метро:
         <input type="text" name="metro" value="{{$validated['metro']??old('metro')}}" placeholder="Остановка метро">
     </label>
     <label>
         Холодильник:
         <input type="checkbox" name="fridge" value="1" @if(!empty($validated['fridge'])) checked @endif>
     </label>
     <label>
         Посудомоечная Машина:
         <input type="checkbox" name="dishwasher" value="1" @if(!empty($validated['dishwasher'])) checked @endif>
     </label>
     <label>
         Стиральная Машина:
         <input type="checkbox" name="clothWasher" value="1" @if(!empty($validated['clothWasher']))checked @endif>
     </label>
     <label>
         Балкон:
         <select name="balcony">
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
     </label>
     <label>
         Санузлы:
         <select name="bathroom">
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
     </label>
     <label>
         Кто разместил:
         <select name="author">
             <option value="1" @if($validated['author']===1) selected @endif>
                 Владелец
             </option>
             <option value="2" @if($validated['author']===2) selected @endif>
                 Агенство
             </option>
         </select>
     </label>
     <label>
         Залог (руб):
         <input type="number" name="pledge" value="{{$validated['pledge']??old('pledge')}}">
     </label>
     <label>
         Инфраструктура:
         <textarea name="infrastructure" placeholder="Инфраструктура">{{$validated['infrastructure']??old('infrastructure')}}</textarea>
     </label>
     <label>
         Описание:
         <textarea name="description" placeholder="Описание">{{$validated['description']??old('description')}}</textarea>
     </label>
 </label>
