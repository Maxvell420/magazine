<x-content :title="$title">
    <h2 class="h2Chats">Список чатов</h2>
    @foreach($chats as $chat)
        @if($chat->messages()->count() > 0)
            <a href="{{ route('chat.show', [$chat->house, $chat]) }}">
                <div class="chat-preview">
                    <h3>{{ $chat->getChatWith($chat->house)->name }}</h3>
                    <p>{{ $chat->getLatestMessage()->text }}</p>
                    @if($chat->getLatestMessage()->user_id != Auth::user()->id)
                        @if($chat->newMessages()->count() > 0)
                            <span class="new-messages">+{{ $chat->newMessages()->count() }}</span>
                        @endif
                    @endif
                </div>
            </a>
        @endif
    @endforeach
</x-content>
