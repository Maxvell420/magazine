<a href="{{route($href)}}">
    <div @if(Route::currentRouteName() === $href) class="navButton current"
            @else
                class="navButton"
        @endif>
        {{$text}}
    </div>
</a>
