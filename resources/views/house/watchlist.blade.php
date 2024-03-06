<x-content>
    <div>
        @if($houses->isNotEmpty())
            @foreach($houses as $house)
                <x-house :house="$house"/>
            @endforeach
        @else
            <h3 style="color: white">Здесь будут обьявление которые вы добавили в избранное</h3>
        @endif
    </div>
</x-content>
