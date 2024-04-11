<x-layout :styles="$styles" :title="$title">
    <x-adminHeader/>
    <div class="wrapper">
        <div class="category">
           <form action="{{route(trans('routes.names.category.update'),$category)}}" method="post">
               @csrf
               <label for="name">{{trans('category.name')}}</label>
               <input id="name" name="name" type="text" placeholder="{{trans('category.name')}}" value="{{$category->name}}">
               <button type="submit">{{trans('category.save')}}</button>
           </form>
        </div>
        <div class="products">
            <h3>{{trans('subcategory.products')}}</h3>
            @foreach($category->products as $product)
                <a href="{{route(trans('routes.names.main.product'),$product)}}">{{trans('routes.texts.main.product',['product_id'=>$product->id])}}</a>
            @endforeach
        </div>
    </div>
</x-layout>
