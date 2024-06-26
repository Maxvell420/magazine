<a href="{{route(trans('routes.names.main.product'),$product)}}">
<div class="product" id="likeProduct_{{$product->id}}">
    <div class="productHead">
        <h3>{{$product->name}}</h3>
        <div class="buttons">
            <button type="button">
                <img src="" alt="heart">
            </button>
            @if(!in_array($product->id,$favourites))
                <form action="{{route(trans('routes.names.product.like'),$product)}}" method="post">
                    <input type="hidden" name="_token" value="{{$token}}">
                    <button type="submit">
                        <img src="{{asset('images/buttons/heart.svg')}}" alt="like">
                    </button>
                </form>
            @else
                <form action="{{route(trans('routes.names.product.dislike'),$product)}}" method="post">
                    <input type="hidden" name="_token" value="{{$token}}">
                    <button type="submit">
                        <img src="{{asset('images/buttons/heart-remove.svg')}}" alt="remove like">
                    </button>
                </form>
            @endif
        </div>
    </div>
    <div class="productInfo">
        <img src="{{asset($product->preview)}}" alt="preview" class="preview">
        <div class="productAbout">
            <div class="productProperties">
                @if($product->quantity>0)
                    <span>{{trans('product.inStock')}}☑</span>
                @endif
                @foreach($product->previewInfo as $property => $value)
                    <span>{{$property}}:{{$value}}</span>
                @endforeach
            </div>
            <div class="productAddition">
            </div>
                <span class="productPrice">{{$product->price}} ₽</span>
        </div>
    </div>
</div>

{{--<script>--}}
{{--    generateCartButtons()--}}
{{--</script>--}}
</a>
