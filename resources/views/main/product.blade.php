<x-layout :styles="$styles" :scripts="$scripts" :title="$title">
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
                        <span>В наличии:☑</span>
                    @endif
                    <span>Добавлен: {{$product->time}}</span>
                </div>
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
            </div>
            <div class="additionalInfo">
                <h4>Характеристики продукта</h4>
                <div class="properties">
                    @foreach($properties as $key => $value)
                        <p>{{$key}}: {{$value}}</p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</x-layout>
<script>
    productEventManager()
    replaceUnderScore()
</script>
