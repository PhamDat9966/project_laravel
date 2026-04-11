<!DOCTYPE html>
<html lang="en">
<head>
    @include('news.elements.head')
</head>
<body>
<div class="super_container">
    <!-- Header -->
    @include('news.elements.header')
    @yield('content')
    <!-- Footer -->
    @include('news.elements.footer')
</div>
    @include('news.elements.script')
    @yield('after_script')
</body>
</html>
