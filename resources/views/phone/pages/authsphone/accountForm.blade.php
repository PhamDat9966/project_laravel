@php
    //dd($item);
@endphp

@extends('phone.main')

    <!-- header start -->
    @include('phone.elements.header')
    <!-- header end -->
    @include('phone.pages.authsphone.child-index.breadcrumb',['nameBreadcrumb'=>'Thông Tin Tài khoản'])
    @include('phone.pages.authsphone.child-index.accountFormView',['user' => $user])

