<x-content :title="$title">
    <div class="form">
        <h2>Подтверждение</h2>
        <form action="{{route('house.save')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="houseMainForm">
                <label for="address">Подтвердите адрес:</label>
                <select name="address" id="address">
                    @foreach($addresses as $address)
                        <option value="{{json_encode($address)}}">
                            {{$address->value}}
                        </option>
                    @endforeach
                </select>
            </div>
            <x-house.crud.confirm :validated="$validated"/>
            <label for="file">Выложить фотографии:</label>
            <input type="file" id="file" name="pictures[]" multiple accept="image/*" required>
            <button type="submit" class="navButton">Разместить</button>
        </form>
    </div>
</x-content>
