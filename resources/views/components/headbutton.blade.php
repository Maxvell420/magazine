<button @if(URL::full() === $href) class="active" @endif><a href="{{$href}}" @if(isset($id)) id="{{$id}}" @endif>{{$text}}</a></button>
