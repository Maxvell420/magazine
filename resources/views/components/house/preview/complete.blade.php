<div class="house">
        <a href="{{route('house.show',$house)}}">
            <img class="housePreview" src="{{asset($house->preview)}}" alt="preview">
            <x-house.info.preview :house="$house"/>
        </a>
    @if(in_array($house->id,$watchlist))
        <form action="{{route('favourite.remove',$house->id)}}" method="post">
            @csrf
            <button type="submit" class="houseButton">
                <img class="liked" src="{{asset('buttons/like/liked.png')}}" alt="like">
            </button>
        </form>
    @else
        <form action="{{route('favourite.add',$house->id)}}" method="post">
            @csrf
            <button type="submit" class="houseButton">
                <img src="{{asset('buttons/like/like.svg')}}" alt="like">
            </button>
        </form>
    @endif
</div>
<script>
    let button = document.querySelector('.liked')
    if (button !== null) {
        button.addEventListener('mouseover', function () {
            button.src = "{{asset('buttons/like/likeDelete.png')}}";
        });

        button.addEventListener('mouseleave', function () {
            button.src = "{{asset('buttons/like/liked.png')}}";
        });
    }
</script>
