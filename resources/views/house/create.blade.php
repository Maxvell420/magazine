<x-content>
    <div class="form">
        <h3>
            Announcement create form
        </h3>
        <form action="{{route('house.confirm')}}" method="post">
            @csrf
            <label>
                <input type="number" required name="rooms" value="{{old('rooms')}}" placeholder="rooms">
            </label>
            <label>
                <input type="number" min="1" name="price" value="{{old('price')}}" required placeholder="price">
            </label>
            <label>
                <textarea name="description" placeholder="description">{{old('description')}}</textarea>
            </label>
            <label>
                <input type="text" name="city" value="{{old('city')}}" placeholder="city">
            </label>
            <label>
                <input type="text" name="street" value="{{old('street')}}" placeholder="street">
            </label>
            <label>
                <input type="text" name="building" value="{{old('building')}}" placeholder="building">
            </label>
            <input type="submit" value="create announcement">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            @if(!str_contains($error, 'title'))
                                <li>{{ $error }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif
        </form>
    </div>
</x-content>
