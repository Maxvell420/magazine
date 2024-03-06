<x-content>
    <div class="form">
        <h3>
            Регистрация
        </h3>
        <form action="{{route('user.save')}}" method="post">
            @csrf
            <label>
                <input type="text" name="name" value="{{old('text')}}" placeholder="name">
            </label>
            <label>
                <input type="password" name="password" value="{{old('password')}}" placeholder="password">
            </label>
            <input type="submit">
        </form>
    </div>
</x-content>
