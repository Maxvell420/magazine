<div class="houseMainForm">
    <x-house.inputs.additional/>

    <label for="pledge">Залог (руб):</label>
    <input type="number" id="pledge" name="pledge" value="{{old('pledge')}}" placeholder="Залог">

    <label for="infrastructure">Инфраструктура:</label>
    <textarea name="infrastructure" id="infrastructure" placeholder="Инфраструктура">{{old('infrastructure')}}</textarea>

    <label for="description">Описание:</label>
    <textarea name="description" id="description" placeholder="Описание">{{old('description')}}</textarea>

</div>
