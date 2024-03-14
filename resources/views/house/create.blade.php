<x-content>
    <div class="form">
        <h2>Создание обьявления</h2>
        <form action="{{route('house.confirm')}}" method="post">
            @csrf
            <x-house.crud.mainInfo/>
            <x-house.crud.additionInfo/>
            <button type="submit">Создать</button>
        </form>
    </div>
</x-content>
