<x-content :title="$title">
    <h3>Ваш список желаемого {{$user->name}}</h3>
    <div class="dashboardWrapper">
        @if($houses->isNotEmpty())
        <div class="articles">
            @foreach($houses as $house)
                <x-house.preview.complete :house="$house" :watchlist="$watchlist"/>
            @endforeach
            {{$houses}}
        </div>
        @else
            <h3 style="color: white">Здесь будут обьявление которые вы добавили в избранное</h3>
        @endif
        <div class="userButtons">
            <a href="{{route('user.show')}}"><button class="navButton">Ваши обьявления</button></a>
            <a href="{{route('watchlist.show')}}"><button class="navButton">Избранные</button></a>
        </div>
    </div>
</x-content>
