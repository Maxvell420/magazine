<x-content>
    <h2>Подтверждение</h2>
    <form action="{{route('house.save')}}" method="post">
        @csrf
        <label>
            Подтвердите адрес:
            <select name="address">
                @foreach($addresses as $address)
                    <option value="{{json_encode($address)}}">
                        {{$address->value}}
                    </option>
                @endforeach
            </select>
        </label>
        <x-house.crud.confirm :validated="$validated"/>
        <input type="submit" value="confirm address">
    </form>
</x-content>
