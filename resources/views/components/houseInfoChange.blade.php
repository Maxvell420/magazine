<div class="houseInfoChange flex">
    <form action="{{route('house.update',$house)}}" method="post" enctype="multipart/form-data" class="flex">
        @csrf
        <label>
            Комнат:
            <input type="number" required name="rooms" value="{{$house->rooms}}" placeholder="Комнат">
        </label>
        <label>
            Цена:
            <input type="number" min="1" name="price" value="{{$house->price}}" required placeholder="Цена">
        </label>
        <label>
            Выложить фотографии:
            <input type="file" name="pictures[]" multiple accept="image/*">
        </label>
        <label>
            Описание:
            <textarea name="description" placeholder="Описание" class="houseText">{{$house->description}}</textarea>
        </label>
        <input type="submit" value="edit announcement">
    </form>
</div>
