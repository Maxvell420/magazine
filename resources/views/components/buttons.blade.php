<div class="houseButtons">
    @auth()
        @if(\Illuminate\Support\Facades\Auth::user()->getHousesFromWatchlist($house->id))
            <form action="{{route('favourite.remove',$house->id)}}" method="post">
                @csrf
                <input class="favouriteRemove houseButton" type="submit" value="&hearts;">
            </form>
        @else
            <div>
                <form action="{{route('favourite.add',$house->id)}}" method="post">
                    @csrf
                    <input class="favouritePut houseButton" type="submit" value="&hearts;">
                </form>
            </div>
        @endif
        @if(\Illuminate\Support\Facades\Auth::user()->id==$house->user_id)
            @if(!$house->archived)
                <form action="{{route('house.archive',$house)}}" method="post">
                    @csrf
                    <input class="archivePut houseButton" type="submit" value="📁">
                </form>
            @else
                <form action="{{route('house.unzip',$house)}}" method="post">
                    @csrf
                    <input class="archiveRemove houseButton" type="submit" value="📁">
                </form>
            @endif
        @endif
        <a href="{{route('complaint.create',$house)}}">
            <button class="complainPut houseButton">!</button>
        </a>
        @if(auth()->user()->role_id>=2)
                <form action="{{route('house.delete',$house)}}" method="post">
                    @csrf
                        <button type="submit" class="houseButton houseRemove">
                            <img src="{{asset('icon/house-delete.jpg')}}" alt="delete user" class="buttonImg">
                        </button>
                </form>
                <form action="{{route('user.ban',$house->user)}}" method="post">
                    @csrf
                    <button type="submit" class="houseButton userRemove">
                        <img src="{{asset('icon/user-delete.png')}}" alt="delete user" class="buttonImg">
                    </button>
                </form>
        @endif
    @endauth
</div>
