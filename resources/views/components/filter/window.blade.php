<div class="filterWindow">
    <form action="#" method="get">
        <div class="priceDiv">
            <label for="price">Цена:</label>
            <input type="number" name="price" id="price" placeholder="Цена" min="0" value="100000">
        </div>
        <div class="filterInputs"></div>
        <button type="submit">Применить</button>
        <button type="button"><a href="{{route('main.dashboard')}}">Сбросить</a></button>
    </form>
</div>
