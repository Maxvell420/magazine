<div class="reviews">
    @if($reviews)
        <h4>{{trans('product.reviews')}}:</h4>
        @foreach($reviews as $review)
            <div class="review">
                <span>{{$review->user->name}}</span>
                <span>{{$review->text}}</span>
                <span>{{$review->time}}</span>
            </div>
        @endforeach
    @else
        <h4>{{trans('product.reviewsNone')}}</h4>
    @endif
    <form action="{{route(trans('routes.names.product.review'),$product->id)}}" method="post">
        <input type="hidden" value="{{csrf_token()}}" name="_token">
        <textarea name="text"></textarea>
        <button type="submit">{{trans('product.reviewCreate')}}</button>
    </form>
</div>
