<div class="filter">
    <form action="{{route('user.dashboard')}}">
        <h3>Поиск по сайту:</h3>
        <x-filter.inputs :cities="$cities" :values="$values"/>
        <button type="submit" class="navButton">Искать</button>
        <button class="navButton"> <a href="{{route('user.dashboard')}}">Сбросить фильтр </a></button>
    </form>
</div>
