<x-content>
    <x-filter :cities="$cities" :values="$values"/>
    <div class="articles">
        @foreach($houses as $house)
            <x-house.main :house="$house" :watchlist="$watchlist"/>
        @endforeach
    </div>
    {{$houses}}
</x-content>
