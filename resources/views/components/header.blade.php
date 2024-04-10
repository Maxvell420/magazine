<div class="header">
    <div class="headerButtons">
        <x-headbutton :href="route(trans('routes.names.main.dashboard'))" :text="trans('routes.texts.main.dashboard')"/>
        <x-headbutton :href="route(trans('routes.names.main.cart'))" :text="trans('routes.texts.main.cart')" :id="'cart'"/>
    </div>

    <div class="headerButtons">
            <x-headbutton :href="$routes[app()->getLocale()]" :text="app()->getLocale()" :id="'language'"/>
            <div class="hidden" id="languages">
                @foreach($routes as $lang => $route)
                    @if($lang == app()->getLocale())
                        @continue
                    @endif
                    <x-headbutton :href="$route" :text="$lang"/>
                @endforeach
            </div>
        @auth
            @if(\Illuminate\Support\Facades\Auth::user()->role_id>1)
                <x-headbutton :href="route(trans('routes.names.main.admin'))" :text="trans('routes.texts.main.admin')"/>
            @endif
            <x-headbutton :href="route(trans('routes.names.main.orders'))" :text="trans('routes.texts.main.orders')"/>
            <x-headbutton :href="route(trans('routes.names.main.favourites'))" :text="trans('routes.texts.main.favourites')"/>
            <x-headbutton :href="route(trans('routes.names.main.logout'))" :text="trans('routes.texts.main.logout')"/>
        @endauth
        @guest
            <x-headbutton :href="route(trans('routes.names.main.login'))" :text="trans('routes.texts.main.login')"/>
            <x-headbutton :href="route(trans('routes.names.user.create'))" :text="trans('routes.texts.user.create')"/>
        @endguest
    </div>
</div>
<script src="{{asset('scripts/header.js')}}"></script>
<script defer>headerButtonEventManager('.headerButtons button')</script>
