<div class="adminHeader">
    <div class="adminHeaderButtons">
        <x-headbutton :href="'main.admin'" :text="'Поиск по заказам'"></x-headbutton>
        <x-headbutton :href="'product.create'" :text="'Создание продукта'"></x-headbutton>
    </div>
</div>
<script defer>headerButtonEventManager('.adminHeaderButtons button')</script>
