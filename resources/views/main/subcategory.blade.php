<x-layout :styles="$styles" :title="$title">
    <x-adminHeader/>
    <div class="wrapper">
        <div class="subcategory">
            <form action="{{route(trans('routes.names.subcategory.update'),$subcategory)}}" method="post">
                @csrf
                <label for="name">{{trans('subcategory.name')}}</label>
                <input id="name" name="name" type="text" placeholder="{{trans('subcategory.name')}}" value="{{$subcategory->name}}">
                <button type="submit">{{trans('subcategory.save')}}</button>
            </form>
        </div>
        <div class="products">
            <h3>{{trans('subcategory.products')}}</h3>
            @foreach($subcategory->products as $product)
                <a href="{{route(trans('routes.names.main.product'),$product)}}">{{trans('routes.texts.main.product',['product_id'=>$product->id])}}</a>
            @endforeach
        </div>
    </div>
</x-layout>
