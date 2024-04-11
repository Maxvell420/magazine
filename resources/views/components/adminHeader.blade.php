<div class="adminHeader">
    <div class="adminHeaderButtons">
{{--        <x-headbutton :href="route(trans('routes.names.main.admin'))" :text="trans('routes.texts.main.admin')"/>--}}
        <x-headbutton :href="route(trans('routes.names.product.create'))" :text="trans('routes.texts.product.create')"/>
        <x-headbutton :href="route(trans('routes.names.main.categories'))" :text="trans('routes.texts.main.categories')"/>
        <x-headbutton :href="route(trans('routes.names.main.subcategories'))" :text="trans('routes.texts.main.subcategories')"/>
{{--        <x-headbutton :href="route(trans('routes.names.main.products'))" :text="trans('routes.texts.main.products')"/>--}}
    </div>
</div>
<script defer>adminHeaderButtonEventManager('.adminHeaderButtons button')</script>
