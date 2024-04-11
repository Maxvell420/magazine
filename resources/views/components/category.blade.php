<a href="{{route(trans('routes.names.category.edit'),$category)}}">
    <div class="category">
        <span>{{trans('form.id')}}:{{$category->id}}</span>
        <span>{{trans('category.name')}}@if($category->name === '')
                {{trans('form.notfound')}}
            @else
                {{$category->name}}
            @endif</span>
        <span>{{trans('form.added')}}:{{$category->time}}</span>
    </div>
</a>
