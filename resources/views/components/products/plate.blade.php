<div class="product" id="likeProduct_{{$product->id}}">
        <img src="{{$product->preview}}" alt="preview" class="preview">
    <div class="productAbout">
        <div class="productHead">
            <h3>{{$product->name}}</h3>
            <h3>{{$product->price}} ₽</h3>
        </div>
        @if($product->quantity>0)
            <span>{{trans('product.inStock')}}☑</span>
        @endif
        <div class="buttons">
            <button type="button">
                <img src="" alt="heart">
            </button>
            @if(!in_array($product->id,$favourites))
                <form action="{{route('product.like',$product)}}" method="post">
                    @csrf
                    <button type="submit">
                        <img src="{{asset('images/buttons/heart.svg')}}" alt="like">
                    </button>
                </form>
            @else
                <form action="{{route('product.dislike',$product)}}" method="post">
                    @csrf
                    <button type="submit">
                        <img src="{{asset('images/buttons/heart-remove.svg')}}" alt="remove like">
                    </button>
                </form>
            @endif
        </div>
        <span>{{trans('product.added')}}{{$product->time}}</span>
    </div>
</div>

<script defer>
    generateCartButtons()
</script>
