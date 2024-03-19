<div class="slider">
    <div class="currentPhoto">
        <img class="housePhoto" src="{{asset($house->preview)}}" alt="currentPhoto">
    </div>
    @if($house->photos->isNotEmpty())
        <div class="imagesBar">
            @foreach($house->photos as $photo)
                <img class="housePhoto" src="{{asset($photo->path.'/'.$photo->name)}}" alt="houseImg">
            @endforeach
        </div>
    @endif
</div>
<script>
    let images = document.querySelectorAll('.imagesBar img')
    let current = document.querySelector('.currentPhoto img')
    for (let img of images) {
        img.addEventListener('click',function () {
            current.src=this.src
        })
    }
</script>
