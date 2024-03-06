<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="{{asset('styles.css')}}">
    @if(session()->has('message'))
        <script>
            let message = "{{ session('message') }}";
        </script>
    @endif
    <script src="{{asset('script.js')}}"></script>
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
</body>
</html>
