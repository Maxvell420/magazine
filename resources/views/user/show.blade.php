<x-content :title="$title">
    <h3>Обьявления пользователя {{$user->name}}:</h3>
    <div class="dashboardWrapper">
        <div class="articles">
            @foreach($houses as $house)
                <x-house.preview.complete :house="$house" :watchlist="$watchlist"/>
            @endforeach
                {{$houses}}
        </div>
        <div class="userButtons">
            <a href="{{route('user.show')}}"><button class="navButton">Ваши обьявления</button></a>
            <a href="{{route('watchlist.show')}}"><button class="navButton">Избранные</button></a>
        </div>
    </div>
</x-content>
