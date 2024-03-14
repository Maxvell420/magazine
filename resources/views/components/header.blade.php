<div class="header">
        <div class="upperButtons">
            <div class="buttons">
                <x-buttons.navbutton :href="'user.dashboard'" :text="'Медуса'"/>
                <x-buttons.navbutton :href="'user.project'" :text="'О проекте'"/>
            </div>
            <div class="buttons">
                <x-buttons.navbutton :href="'house.create'" :text="'Разместить'"/>
                @if(auth()->check())
                    @if(auth()->user()->role_id>1)
                        <x-buttons.navbutton :href="'admin.statistics'" :text="'Админка'"/>
                    @endif
                        <x-buttons.navbutton :href="'chats.show'" :text="'Ваши чаты'"/>
                        <x-buttons.navbutton :href="'user.show'" :text="'Кабинет'"/>
                        <x-buttons.navbutton :href="'logout'" :text="'Выйти'"/>
                @else
                    <x-buttons.navbutton :href="'login'" :text="'Войти'"/>
                    <x-buttons.navbutton :href="'user.create'" :text="'Регистрация'"/>
                @endif
            </div>
        </div>
        <div class="lowerButtons">

        </div>
</div>
