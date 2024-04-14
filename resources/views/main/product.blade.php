<x-layout :styles="$styles" :title="$title">
    <div class="wrapper">
        <div class="product" id="{{$product->id}}">
            <div class="productHead">
                <h3>{{$product->name}}</h3>
                <h3>{{$product->price}} ₽</h3>
            </div>
            <div class="MainInfo">
                <img src="{{asset($product->preview)}}" alt="{{$product->name}}" class="preview">
                <div class="productInfo">
                    @if($product->quantity > 0)
                        <span>{{trans('product.inStock')}} : ☑</span>
                    @endif
                    <span>{{trans('product.added')}} : {{$product->time}}</span>
                </div>
                <div class="buttons">
                    <button type="button">
                        <img src="" alt="heart">
                    </button>
                    @if(!in_array($product->id,$favourites))
                        <form action="{{route(trans('routes.names.product.like'),$product)}}" method="post">
                            @csrf
                            <button type="submit">
                                <img src="{{asset('images/buttons/heart.svg')}}" alt="like">
                            </button>
                        </form>
                    @else
                        <form action="{{route(trans('routes.names.product.dislike'),$product)}}" method="post">
                            @csrf
                            <button type="submit">
                                <img src="{{asset('images/buttons/heart-remove.svg')}}" alt="remove like">
                            </button>
                        </form>
                    @endif
                    @auth
                        @if(\Illuminate\Support\Facades\Auth::user()->role_id>1)
                            <form action="{{route(trans('routes.names.product.edit'),[$product])}}">
                                <button>
                                    <a href="{{route(trans('routes.names.product.edit'),[$product])}}">
                                        <img src="{{asset('images/buttons/edit.svg')}}" alt="product edit">
                                    </a>
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
            @if(isset($properties))
                <div class="additionalInfo">
                    <h4>Характеристики продукта</h4>
                    <div class="properties">
                        @foreach($properties as $key => $value)
                            <p>{{$key}}: {{$value}}</p>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

</x-layout>
<script>
    productEventManager(@json(trans('form')))
    replaceUnderScore()
</script>
