<x-layout :styles="$styles" :title="$title">
    <div class="container">
        <h2>{{trans('routes.texts.main.login')}}</h2>
        <form action="{{route(trans('routes.names.user.auth'))}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">{{trans('form.name')}}:</label>
                <input type="text" id="name" name="name" placeholder="{{trans('form.name')}}" required>
            </div>
            <div class="form-group">
                <label for="password">{{trans('form.password')}}:</label>
                <input type="password" id="password" name="password" placeholder="{{trans('form.password')}}" required>
            </div>
            <button type="submit">{{trans('routes.texts.main.login')}}</button>
        </form>
    </div>
</x-layout>
