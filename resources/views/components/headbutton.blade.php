<button @if(Route::currentRouteName() === $href) class="active" @endif><a href="{{route($href)}}" @if(isset($id)) id="{{$id}}" @endif>{{$text}}</a></button>
