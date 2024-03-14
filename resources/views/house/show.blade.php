<x-content>
    @if($house->user->frozen)
        <x-frozen :house="$house"/>
    @else

        <h3>{{$house->coordinate->getAddress()}}</h3>
        <div class="houseWrapper">

            <x-slider :house="$house"/>

            <div class="houseBlock">
                <p>
                    Price: {{$house->price}}
                </p>
                <p>
                    Number of rooms: {{$house->rooms}}
                </p>
                <p>
                    {{$house->description}}
                </p>
                <div class="flex">
                    <x-buttons :house="$house"/>
                    @auth
                        <a href="{{route('chat.show',$house)}}"><button class="chatPut houseButton">🗨</button></a>
                    @endauth
                </div>
            </div>
        </div>
        @auth
            @if(\Illuminate\Support\Facades\Auth::user()->id==$house->user_id)
                <div class="houseEdit">
                    <x-houseInfoChange :house="$house"/>
                </div>
            @endif
        @endauth
    @endif
</x-content>
