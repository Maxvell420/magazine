<div class="header">
    <div class="buttons">
        <a href="{{route('user.dashboard')}}">
            <div class="headerButton">
                Главная страница
            </div>
        </a>
        <div class="log">
            <a href="{{route('house.create')}}">
                <div class="headerButton">
                    Создать обьявление
                </div>
            </a>
            @if(auth()->check())
                @if(auth()->user()->role_id>1)
                    <a href="{{route('admin.statistics')}}">
                        <div class="headerButton">
                            Админка
                        </div>
                    </a>
                @endif
                <a href="{{route('chats.show')}}">
                    <div class="headerButton">
                        Ваши чаты
                    </div>
                </a>
                <a href="{{route('user.show')}}">
                    <div class="headerButton">
                        Кабинет
                    </div>
                </a>
                <a href="{{route('logout')}}">
                    <div class="headerButton">
                        logout
                    </div>
                </a>
            @else
                <a href="{{route('login')}}">
                    <div class="headerButton">
                        login
                    </div>
                </a>
                <a href="{{route('user.create')}}">
                    <div class="headerButton">
                        Регистрация
                    </div>
                </a>
            @endif
        </div>
    </div>
</div>
