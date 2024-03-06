<x-content>
    @if($house->user->frozen)
        <x-frozen :house="$house"/>
        @else
        <div class="chat">
            <x-house :house="$house"/>
            @foreach($chat->messages as $message)
                <div class="@if(\Illuminate\Support\Facades\Auth::user()->id==$message->user->id)
         rightMessage
         @else
         leftMessage
        @endif
        ">
                    {{$message->user->name}}
                    {{$message->text}}
                </div>
            @endforeach
            <form action="{{route('message.create',$chat)}}" method="post">
                @csrf
                <label>
                    <textarea name="text"></textarea>
                </label>
                <input type="submit" @if($house->archived) disabled
                    value="archived" @else value="send message @endif">
            </form>
        </div>
    @endif
</x-content>
