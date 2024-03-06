<x-content>
    <x-filter :cities="$cities" :values="$values" :route="$route"/>
    <div class="articles">
        @foreach($houses as $house)
            <x-house :house="$house"/>
        @endforeach
    </div>
    {{$houses}}
</x-content>
