<x-content :title="$title">
    <div class="edit">
        <h2>Редактирование обьявления: {{$house->title}}</h2>

        <div class="photos">
            @foreach($house->photos as $photo)
                <div class="photoEdit">
                    <img src="{{asset($photo->path.'/'.$photo->name)}}" alt="house img">
                    <form action="{{route('photo.delete',[$house,$photo])}}" method="post">
                        @csrf
                        <button type="submit" class="navButton">удалить фотографию</button>
                    </form>
                </div>
            @endforeach
        </div>
        <div class="eform">
            <form action="{{route('house.update',$house)}}" method="post" enctype="multipart/form-data">

                <label for="title">
                    <span>Заголовок:</span>
                    <input type="text" id="title" name="title" placeholder="Заголовок" value="{{$house->title??old('title')}}">
                </label>


                <label for="price"><span>Цена:
                </span>
                    <input type="number" id="price" min="1" name="price" value="{{$house->price??old('price')}}" required placeholder="Цена">
                </label>


                <label for="metro">
                    <span>Метро:</span>
                    <input type="text" id="metro" name="metro" value="{{$info['metro']??old('metro')}}" placeholder="Остановка метро">
                </label>

                <label for="rooms">
                    <span>Комнат:</span>
                    <input type="number" id="rooms" name="rooms" value="{{$info['rooms']??old('rooms')}}" placeholder="Число комнат">
                </label>

                <label for="fridge">
                    <span>Холодильник:</span>
                    <input type="checkbox" id="fridge" name="fridge" @if($info['fridge']==1) checked @endif value="1">
                </label>

                <label for="dishwasher">
                    <span>Посудомойка:</span>
                    <input type="checkbox" id="dishwasher" name="dishwasher" @if($info['dishwasher']==1) checked @endif value="1">
                </label>


                <label for="clothWasher">
                    <span>Стиралка:</span>
                    <input type="checkbox" id="clothWasher" name="clothWasher" @if($info['clothWasher']==1) checked @endif value="1">
                </label>

                <label for="file">
                    <span>Выложить фотографии:</span>
                    <input type="file" id="file" name="pictures[]" multiple accept="image/*">
                </label>

                <label for="balcony">
                    <span>Балкон:</span>
                    <select id="balcony" name="balcony">
                        <option value="0">
                            Нет
                        </option>
                        <option value="1" @if($info['balcony']==1) selected @endif>
                            Лоджия
                        </option>
                        <option value="2" @if($info['balcony']==2) selected @endif>
                            Балкон
                        </option>
                        <option value="3" @if($info['balcony']==3) selected @endif>
                            Несколько балконов
                        </option>
                    </select>
                </label>


                <label for="bathroom">
                <span>
                    Санузел:
                </span>
                    <select id="bathroom" name="bathroom">
                        <option value="1" @if($info['bathroom']==1) selected @endif>
                            Совмещенный
                        </option>
                        <option value="2" @if($info['bathroom']==2) selected @endif>
                            Раздельный
                        </option>
                        <option value="3" @if($info['bathroom']==3) selected @endif>
                            2 и более
                        </option>
                    </select>
                </label>

                <label for="author">
                    <span>Кто разместил:</span>
                    <select id="author" name="author">
                        <option value="1" @if($info['author']==1) selected @endif>
                            Владелец
                        </option>
                        <option value="2" @if($info['author']==2) selected @endif>
                            Агенство
                        </option>
                    </select>
                </label>

                <label for="description">
                    <span>Описание:</span>
                    <textarea name="description" id="description">{{$info['description']}}</textarea>
                </label>

                <label for="submit">
                    <button id="submit" type="submit">Сохранить</button>
                </label>
                @csrf
            </form>
        </div>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</x-content>
