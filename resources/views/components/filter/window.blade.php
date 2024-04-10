<div class="filterWindow">
    <form action="#" method="get">
        <div class="priceDiv">
            <label for="price">{{trans('filter.price')}}</label>
            <input type="number" name="price" id="price" placeholder="Цена" min="0" value="100000">
        </div>
        <div class="filterInputs"></div>
        <button type="submit">{{trans('filter.apply')}}</button>
        <button type="button"><a href="{{route(trans('routes.names.main.dashboard'))}}">{{trans('filter.reset')}}</a></button>
    </form>
</div>
