<x-content>
    <x-Adminheader/>
        <x-filter :cities="$cities" :values="$values" :route="$route"/>
        <div class="articles">
            @foreach($houses as $house)
                <div>
                    <x-houseInfoPreview :house="$house"/>
                    <x-buttons :house="$house"/>
                    <form action="{{route('house.delete',$house)}}" method="post">
                        @csrf
                        <input type="submit" value="delete.house">
                    </form>
                    <form action="{{route('user.ban',$house->user)}}" method="post">
                        @csrf
                        <input type="submit" value="ban user">
                    </form>
                </div>
            @endforeach
        </div>
</x-content>
