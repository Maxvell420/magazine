<x-content>
    <x-adminheader/>
    <div>
        @foreach($users as $user)
            @foreach($user->complaints as $complaint)
                <div>
                    {{$complaint->text}}
                    {{$complaint->created_at->toDateString()}}
                </div>
            @endforeach
            <a href="{{route('user.houses',$user)}}">{{$user->name}} houses</a>
            <form action="{{route('user.unfreeze',$user)}}" method="post">
                @csrf
                <input type="submit" value="unfreeze user">
            </form>
            <form action="{{route('user.ban',$user)}}" method="post">
                @csrf
                <input type="submit" value="ban user">
            </form>
        @endforeach
    </div>
</x-content>
