<div class="adminHeader">
    <div class="adminHeaderButtons">
        <x-headbutton :href="route(trans('routes.names.main.admin'))" :text="trans('routes.texts.main.admin')"/>
        <x-headbutton :href="route(trans('routes.names.product.create'))" :text="trans('routes.texts.product.create')"/>
    </div>
</div>
<script defer>adminHeaderButtonEventManager('.adminHeaderButtons button')</script>
