<x-content :title="$title">
    <div class="housePlate">
        <div class="houseHeader">
            <h2 class="fontHeader">{{$house->title}}</h2>
            @if(in_array($house->id,$watchlist))
                <form action="{{route('favourite.remove',$house->id)}}" method="post">
                    @csrf
                    <button type="submit" class="houseButton absolute" style="bottom: 0;left: 0">
                        <img class="liked" src="{{asset('buttons/like/liked.png')}}" alt="like">
                    </button>
                </form>
            @else
                <form action="{{route('favourite.add',$house->id)}}" method="post">
                    @csrf
                    <button type="submit" class="houseButton absolute" style="bottom: 0;left: 0">
                        <img src="{{asset('buttons/like/like.svg')}}" alt="like">
                    </button>
                </form>
            @endif
        </div>
        <div class="houseOwner">
            <div class="flexColumn">
            <span class="fontHeader">
                {{$house->price}} ₽
            </span>
                    <a href="{{route('user.show',$house->user->id)}}" class="flexColumn" style="margin: 0">
                        <span>Продавец: {{$house->user->name}}</span>
                        <span>Зарегистрирован: {{$house->user->time}}</span>
                    </a>
                @auth
                    @if($user->id != $house->user_id)
                        <a href="{{route('chat.show',$house)}}"><button class="navButton">Написать продавцу</button></a>
                        <a href="{{route('complaint.create',$house)}}"><button class="navButton">Жалоба</button></a>
                    @endif
                        @if($user->id == $house->user_id)
                            <a href="{{route('house.edit',$house)}}"><button class="navButton">Редактировать</button></a>
                            @if(!$house->archived)
                                <form action="{{route('house.archive',$house)}}" method="post">
                                    @csrf
                                    <button type="submit" class="navButton">Архивировать</button>
                                </form>
                            @else
                                <form action="{{route('house.unzip',$house)}}" method="post">
                                    @csrf
                                    <button type="submit" class="navButton">Разархивировать</button>
                                </form>
                            @endif
                        @endif
                @endauth
            </div>
        </div>
            <x-house.info.slider :house="$house"/>
        <div class="houseInfo">
            @if(array_key_exists('rooms', $data))
                    <span class="attribute">Количество комнат:</span>
                    <span>{{ $data['rooms'] }}</span>
            @endif

            @if(array_key_exists('fridge', $data))
                    <span class="attribute">Холодильник:</span>
                    <span>Есть</span>
            @endif

            @if(array_key_exists('dishwasher', $data))
                    <span class="attribute">Посудомоечная машина:</span>
                    <span>Есть</span>
            @endif

            @if(array_key_exists('clothWasher', $data))
                    <span class="attribute">Стиральная машина:</span>
                    <span>Есть</span>
            @endif

            @if(array_key_exists('balcony', $data))
                    <span class="attribute">Балкон:</span>
                    @if($data['balcony']==0)
                        <span>Нет</span>
                    @elseif($data['balcony']==1)
                        <span>Лоджия</span>
                    @elseif($data['balcony']==2)
                        <span>Балкон</span>
                    @elseif($data['balcony']==3)
                        <span>Несколько балконов</span>
                    @endif
            @endif

            @if(array_key_exists('bathroom', $data))
                    <span class="attribute">Ванная комната:</span>
                    @if($data['bathroom']==1)
                        <span>Совмещенный</span>
                    @elseif($data['bathroom']==2)
                        <span>Раздельный</span>
                    @elseif($data['bathroom']==3)
                        <span>Раздельный</span>
                    @endif
            @endif

            @if(array_key_exists('pledge', $data))
                    <span class="attribute">Залог:</span>
                    <span>{{ $data['pledge'] }} ₽</span>
            @endif

            @if(array_key_exists('infrastructure', $data))
                    <span class="attribute">Инфраструктура:</span>
                    <span>{{ $data['infrastructure'] }}</span>
            @endif

            @if(array_key_exists('author', $data))
                    <span class="attribute">Автор:</span>
                    @if($data['author']==1)
                        <span>Владелец</span>
                    @elseif($data['author']==2)
                        <span>Агенство</span>
                    @endif
            @endif

            @if(array_key_exists('description', $data))
                    <span class="attribute">Описание:</span>
                    <span>{{ $data['description'] }}</span>
            @endif
        </div>
    </div>
</x-content>
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
