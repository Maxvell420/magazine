<x-content>
    <div class="dashboardWrapper">
        <x-filter.main :cities="$cities" :values="$values"/>
        <div class="flexColumn">
            <h2 class="dashboardHeader">Доступные квартиры для аренды:</h2>
            <div class="articles">
                @foreach($houses as $house)
                    <x-house.preview.complete :house="$house" :watchlist="$watchlist"/>
                @endforeach
            </div>
        </div>
        {{$houses}}
    </div>
</x-content>
