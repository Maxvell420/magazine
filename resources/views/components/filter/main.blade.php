<div class="filter">
    <form action="{{route('user.dashboard')}}">
        <h3>Поиск по сайту:</h3>
        <x-filter.inputs :cities="$cities" :values="$values"/>
        <button type="submit" class="navButton">Искать</button>
    </form>
        <a href="{{route('user.dashboard')}}"><button class="navButton filterReset"><span>Сбросить фильтр</span></button></a>
</div>
