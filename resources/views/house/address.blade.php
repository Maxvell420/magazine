<x-content>
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
            <input type="submit" value="confirm address">
        </form>
    </div>
</x-content>
