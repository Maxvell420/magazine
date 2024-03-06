<x-content>
    <form action="{{route('house.save')}}" method="post">
        @csrf
        <label>
            <input type="text" value="{{$validated['rooms']}}" name="rooms" readonly>
        </label>
        <label>
            <input type="text" value="{{$validated['price']}}" name="price" readonly>
        </label>
        <label>
            <input type="text" value="{{$validated['description']}}" name="description" readonly>
        </label>
        <label>
            <select name="address">
                @foreach($addresses as $address)
                    <option value="{{json_encode($address)}}">
                        {{$address->value}}
                    </option>
                @endforeach
            </select>
        </label>
        <input type="submit" value="confirm address">
    </form>
</x-content>
