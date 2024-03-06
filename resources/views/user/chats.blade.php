<x-content>
    @foreach($chats as $chat)
        @if($chat->messages()->count() > 0)
            <a href="{{ route('chat.show', [$chat->house, $chat]) }}">
                <div class="chat_preview">
                    {{$chat->getChatWith($chat->house)->name}}
                    {{$chat->getLatestMessage()->first()->text}}
                    @if($chat->newMessages()->count()>0)
                        +{{$chat->newMessages()->count()>0}}
                    @endif
                </div>
            </a>
        @endif
    @endforeach
</x-content>
