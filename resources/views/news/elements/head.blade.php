@php
    $categoryName = request()->category_name;
    $title  = ($categoryName != '') ? $categoryName : 'Index';
@endphp
<title>Blog | {{$title}}</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Tech Mag template project">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/x-icon" href="images/favicons.png">
<link rel="stylesheet" type="text/css" href="{{asset('news/css/bootstrap-4.1.2/bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('news/css/font-awesome-4.7.0/css/font-awesome.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('news/js/OwlCarousel2-2.2.1/owl.carousel.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('news/js/OwlCarousel2-2.2.1/owl.theme.default.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('news/js/OwlCarousel2-2.2.1/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('news/css/main_styles.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('news/css/responsive.css')}}">
<!-- Tạo calendar với Bootstrap Datepicker -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_blue.css">

<link rel="stylesheet" type="text/css" href="{{asset('news/css/my-style.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('news/css/my-category.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('news/css/dropdown.css')}}">

