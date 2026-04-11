@php
    //dd($item);
@endphp

@extends('phone.main')
    <!-- header start -->
    @include('phone.elements.header')
    @include('phone.templates.error')
    <!-- header end -->
    @include('phone.pages.authsphone.child-index.breadcrumb',['nameBreadcrumb'=>'Giỏ hàng'])
    @include('phone.pages.authsphone.child-index.cartView',['cart' => $cart,'buy_url' => $buy_url])

