<!DOCTYPE html>
<html lang="en">

<head>
    @include('phone.elements.head')
</head>

<body>
    @include('phone.elements.loader-skeleton')

    <!-- header start -->
    @include('phone.elements.header')
    <!-- header end -->

    @yield('content')

    <!-- footer -->
    @include('phone.elements.footer')
     <!-- footer end -->

    <!-- tap to top -->
    <div class="tap-top top-cls">
        <div>
            <i class="fa fa-angle-double-up"></i>
        </div>
    </div>
    <!-- tap to top end -->

    @include('phone.elements.script')
</body>

</html>
