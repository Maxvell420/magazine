<x-content>
    <h3>Обьявления пользователя {{$user->name}}:</h3>
    <div class="dashboardWrapper">
        <div class="articles">
            @foreach($houses as $house)
                <x-house.preview.complete :house="$house" :watchlist="$watchlist"/>
            @endforeach
        </div>
        {{$houses}}
    </div>
</x-content>
