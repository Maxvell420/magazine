<x-content>
    <div class="form">
        <h3>
            Login
        </h3>
        <form action="{{route('auth')}}" method="post">
            @csrf
            <label>
                <input type="text" name="name" placeholder="name" value="{{old('name')}}">
            </label>
            <label>
                <input type="password" name="password" placeholder="password" value="{{old('password')}}">
            </label>
            <input type="submit" value="login">
        </form>
    </div>
</x-content>
