<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="{{asset('styles.css')}}">
    <link rel="icon" href="{{asset('user.png')}}" sizes="32x32">
    <title>{{$title??'my cool title'}}</title>
</head>
<body>
<div class="wrapper">

    <header>
        <x-header/>
    </header>
    <main>
        <div class="content">
            {{$slot}}
        </div>
    </main>
</div>
@if(session()->has('message'))
    <script>
        let message = "{{ session('message') }}";
    </script>
@endif
<script src="{{asset('script.js')}}"></script>
</body>
</html>
