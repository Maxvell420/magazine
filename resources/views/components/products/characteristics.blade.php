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
