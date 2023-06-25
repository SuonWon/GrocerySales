@props(['title'])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{$title}}</title>

    <!-- fontawesome  -->
    <link href="{{ asset('./assets/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <!-- bootstrap css 1 js1 -->
    <link href="{{ asset('./assets/css/bootstrap.min.css') }}" rel="stylesheet"  type="text/css" />

 
</head>
<body>
       <x-navbar></x-navbar>

      {{$slot}}
      
     {{-- <x-footer></x-footer> --}}

     <!-- jquery js1  -->
    <script src="{{ asset('./assets/js/jquery.min.js') }}" type="text/javascript"></script>

    <!-- bootstrap css1 js1  -->
    <script src="{{ asset('./assets/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
    

</body>
</html>