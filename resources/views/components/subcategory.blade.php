<a href="{{route(trans('routes.names.subcategory.edit'),$subcategory)}}">
    <div class="subcategory">
        <span>{{trans('form.id')}}:{{$subcategory->id}}</span>
        <span>{{trans('category.name')}}@if($subcategory->name === '')
                {{trans('form.notfound')}}
            @else
                <p>
                    {{$subcategory->name}}
                </p>
            @endif
        </span>
        <span>{{trans('form.added')}}:{{$subcategory->time}}</span>
    </div>
</a>
