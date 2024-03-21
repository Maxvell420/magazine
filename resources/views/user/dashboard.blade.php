<x-content :title="$title">
    <div class="dashboardWrapper">
        <x-filter.main :cities="$cities" :values="$values"/>
        <div class="flexColumn">
            <div class="articles">
                <h2 class="dashboardHeader">Доступные квартиры для аренды:</h2>
                @foreach($houses as $house)
                    <x-house.preview.complete :house="$house" :watchlist="$watchlist"/>
                @endforeach
            </div>
        </div>
        {{$houses}}
    </div>
</x-content>
<script>
    let buttons = document.querySelectorAll('.liked')
    for (let button of buttons) {
        button.addEventListener('mouseover', function () {
            button.src = "{{asset('buttons/like/likeDelete.png')}}";
        });

        button.addEventListener('mouseleave', function () {
            button.src = "{{asset('buttons/like/liked.png')}}";
        });
    }
</script>
