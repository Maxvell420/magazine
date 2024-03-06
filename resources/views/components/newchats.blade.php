Новые чаты за дату: {{$date}}
<ol>
    @foreach($chats as $chat)
    <li>
        {{$chat->name}} +{{$chat->counter}}
    </li>
    @endforeach
</ol>
