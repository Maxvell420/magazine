<div class="slider">
    <div class="imagesBar">
        @if(!$house->photos->isEmpty())
            <table style="border-collapse: collapse;" class="sliderTable">
                <tr class="trPhoto">
                    <td>
                        <img class="imgPreview mainImage" src="{{asset($house->coordinate->path.'/'.$house->coordinate->name)}}" alt="map">
                    </td>
                </tr>
            @foreach($house->photos as $photo)
                <tr class="trPhoto">
                    <td>
                        <img class="imgPreview" src="{{asset($photo->path.'/'.$photo->name)}}" alt="img" onclick="changeImage(this.src)">
                    </td>
                    @auth
                        @if(auth()->user()->id==$house->user_id)
                            <td>
                                <form action="{{route('photo.delete',$photo)}}" method="post">
                                    @csrf
                                    <input type="submit" class="houseButton Remove" value="x">
                                </form>
                            </td>
                        @endif
                    @endauth
                </tr>
            @endforeach
            </table>
        @endif
    </div>
    <img id="mainImage" src="{{asset($house->coordinate->path.'/'.$house->coordinate->name)}}" alt="map">
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var imgPreviews = document.querySelectorAll('.imgPreview');

        imgPreviews.forEach(function (imgPreview) {
            imgPreview.addEventListener('click', function () {
                changeImage(imgPreview.src);
            });
        });
    });

    function changeImage(newSrc) {
        var mainImage = document.getElementById('mainImage');
        mainImage.src = newSrc;
    }
</script>
