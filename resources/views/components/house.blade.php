<div class="house">
    <div class="housePlate">
        <a href="{{route('house.show',$house)}}">
            <div>
                <img class="housePreviewImg" src="{{asset($house->getPreviewPath())}}" alt="preview">
            </div>
        </a>
        <div class="houseBar">
            <div>
                Размещено:{{$house->created_at->toDateString()}}
            </div>
        </div>
    </div>
</div>
