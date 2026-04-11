@extends('phone.main')

@section('content')
    <!-- Home slider -->
    @include('phone.block.slider')
    <!-- Home slider end -->

    <!-- Top Collection -->
    @include('phone.pages.home.child-index.feature-collection',['items'=>$itemsFeature])
    <!-- Top Collection end-->

    <!-- service layout -->
    @include('phone.block.service')
    <!-- service layout  end -->

    <!-- Tab product -->
    @include('phone.pages.home.child-index.category-feature',['categoryIsFeatures'=>$categoryIsFeatures])
    <!-- Tab product end -->

    <!--Modal message-->
    @include('phone.block.quick-view')
    @include('phone.block.message')
    <!--End Modal message-->

@endsection
