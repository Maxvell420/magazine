<x-content :title="$title">
    <div class="form-container">
        <form action="{{route('user.save')}}" method="post">
            <h3 class="form-title">Регистрация</h3>
            @csrf
            <label>
                <span>Логин</span>
                <input type="text" name="name" class="form-input" value="{{old('text')}}" placeholder="Логин">
            </label>
            <label>
                <span>Пароль</span>
                <input type="password" name="password" class="form-input" value="{{old('password')}}" placeholder="Пароль">
            </label>
            <button type="submit" class="form-button">Зарегистрироваться</button>
        </form>
    </div>
</x-content>
