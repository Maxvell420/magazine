<!DOCTYPE html>
<html>
<head>
    <title>@if(isset($title)){{$title}} @else my cool title @endif </title>
    @if(isset($styles))
        <link rel="stylesheet" href="{{asset($styles)}}">
    @endif
    <link rel="stylesheet" href="{{asset('css/layout/layout.css')}}">
</head>
<body>
    <x-header/>
    <main>
        <script src="{{asset('bundle.js')}}"></script>
        @if(isset($scripts))
            <script src="{{asset($scripts)}}"></script>
        @endif
            {{$slot}}
    </main>
</body>
</html>
