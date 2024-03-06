Новые обьявления за дату: {{$date}}
<ol>
    @foreach($houses as $house)
        <li>
            {{$house->name}} +{{$house->counter}}
        </li>
    @endforeach
</ol>
