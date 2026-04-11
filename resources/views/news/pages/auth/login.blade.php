@extends('news.login')
@section('content')
    <div class="card fat">
        <div class="card-body">
            <h4 class="card-title">Đăng Nhập</h4>
            @include('news.templates.error')
            @include('news.templates.alert')
            <!--- Sử dụng spatie/laravel-html --->
            {{ html()->form('POST', route($controllerName.'/postLogin'))->attribute('accept-charset', 'UTF-8')->id('login-form')->open() }}

                <div class="form-group">
                    {{ html()->label('E-Mail Address', 'email') }}
                    {{ html()->email('email')->class('form-control')->required()->autofocus() }}
                </div>

                <div class="form-group">
                    {{ html()->label('Password', 'password') }}
                    {{ html()->password('password')->class('form-control')->required()->autofocus()->attribute('data-eye', 'true') }}
                </div>

                <div class="form-group no-margin">
                    {{ html()->submit('Đăng Nhập')->class('btn btn-primary btn-block') }}
                </div>

            {{ html()->form()->close() }}
        </div>
    </div>
    <div class="footer">
        <p>E-Mail: admin@gmail.com
        password: 123456</p>
        Copyright &copy; Your Company 2017
    </div>
@endsection
