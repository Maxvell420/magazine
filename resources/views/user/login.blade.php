<x-content :title="$title">
    <div class="form-container">
        <form action="{{route('auth')}}" method="post">
            <h3 class="form-title">Вход:</h3>
            @csrf
            <label>
                <span>Логин</span>
                <input type="text" name="name" class="form-input" placeholder="Логин" value="{{old('name')}}">
            </label>
            <label>
                <span>Пароль</span>
                <input type="password" name="password" class="form-input" placeholder="Пароль" value="{{old('password')}}">
            </label>
            <button type="submit" class="form-button">Войти</button>
        </form>
    </div>
</x-content>
