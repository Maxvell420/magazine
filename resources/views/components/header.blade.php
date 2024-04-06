<div class="header">
    <div class="headerButtons">
        <x-headbutton :href="'main.dashboard'" :text="'Медуса'"></x-headbutton>
        <x-headbutton :href="'main.cart'" :text="'Корзина:0'" :id="'cart'"></x-headbutton>
    </div>
    <div class="headerButtons">
        @auth
            @if(\Illuminate\Support\Facades\Auth::user()->role_id>1)
                <x-headbutton :href="'main.admin'" :text="'Админка'"></x-headbutton>
            @endif
            <x-headbutton :href="'main.orders'" :text="'Ваши Заказы'"></x-headbutton>
            <x-headbutton :href="'main.favourites'" :text="'Избранные товары'"></x-headbutton>
            <x-headbutton :href="'user.logout'" :text="'Выход'"></x-headbutton>
        @endauth
        @guest
            <x-headbutton :href="'user.login'" :text="'Вход'"></x-headbutton>
            <x-headbutton :href="'user.create'" :text="'Регистрация'"></x-headbutton>
        @endguest
    </div>
</div>
<script src="{{asset('scripts/header.js')}}"></script>
<script defer>headerButtonEventManager('.headerButtons button')</script>
