@php
    //dd($item);
@endphp

@extends('phone.main')
@section('content')
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="page-title">
                        <h2 class="py-2">
                            Đăng nhập </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="login-page section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h3>Đăng nhập</h3>
                    @include('phone.templates.error')
                    @include('phone.templates.alert')

                    <div class="theme-card">
                        <form action="{!!Route($controllerName.'/postLogin')!!}" method="post"
                            id="admin-form" class="theme-form">
                            @csrf
                            <div class="form-group">
                                <label for="email" class="required">Email</label>
                                <input type="email" id="email" name="email" value="" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="password" class="required">Mật khẩu</label>
                                <input type="password" id="password" name="password" value=""
                                    class="form-control">
                            </div>
                            <button type="submit" id="submit" name="submit" value="Đăng nhập" class="btn btn-solid">Đăng nhập</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 right-login">
                    <h3>Khách hàng mới</h3>
                    <div class="theme-card authentication-right">
                        <h6 class="title-font">Đăng ký tài khoản</h6>
                        <p>Đăng ký tài khoản miễn phí tại cửa hàng của chúng tôi. Đăng ký nhanh chóng và dễ dàng.
                            Nó cho phép bạn có thể đặt hàng từ cửa hàng của chúng tôi. Để bắt đầu mua sắm, hãy nhấp vào đăng ký.</p>
                        <a href="register.html" class="btn btn-solid">Đăng ký</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
