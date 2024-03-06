<x-content>
    <div>
        <a href="{{route('watchlist.show')}}">Избранное</a>
    </div>
    @foreach($houses as $house)
        <x-house :house="$house"/>
    @endforeach
</x-content>
