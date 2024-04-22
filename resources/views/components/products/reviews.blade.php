<div>
    @if(isset($reviews))
        @foreach($reviews as $review)
            <div class="review">
                <span>{{$review->text}}</span>
            </div>
        @endforeach
    @endif
    <form action="{{route(trans('routes.names.product.review'),$product->id)}}" method="post">
        <input type="hidden" value="{{csrf_token()}}" name="_token">
        <textarea name="text"></textarea>
        <button type="submit">{{trans('product.reviewCreate')}}</button>
    </form>
</div>
