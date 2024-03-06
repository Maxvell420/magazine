<x-content>
    @foreach($houses as $house)
        <x-house :house="$house"/>
    @endforeach
</x-content>
