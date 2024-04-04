<x-layout :styles="$styles" :title="$title">
    <div class="container">
        <h2>Вход</h2>
        <form action="{{route('user.auth')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Имя</label>
                <input type="text" id="name" name="name" placeholder="Имя" required>
            </div>
            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" placeholder="Пароль" required>
            </div>
            <button type="submit">Авторизоваться</button>
        </form>
    </div>
</x-layout>
