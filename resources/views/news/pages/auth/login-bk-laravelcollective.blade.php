@extends('news.login')
@section('content')
    <div class="card fat">
        <div class="card-body">
            <h4 class="card-title">Đăng Nhập</h4>
            @include('news.templates.error')
            @include('news.templates.alert')
            {!! Form::open([
                'url'               =>  Route($controllerName.'/postLogin'),
                'method'            =>  'POST',
                'accept-charset'    =>  'UTF-8',
                'id'                =>  'login-form'
            ]) !!}
                <div class="form-group">
                    {!!Form::label('email', 'E-Mail Address')!!}
                    {!!Form::email('email', '',['class'=> 'form-control','required'=>true,'autofocus'=>true])!!}
                </div>
                <div class="form-group">
                    {!!Form::label('password', 'Password')!!}
                    {!!Form::password('password',['class'=> 'form-control','required'=>true,'autofocus'=>true,'data-eye'=>true])!!}
                </div>
                <div class="form-group no-margin">
                    {!!Form::submit('Đăng Nhập',['class'=>'btn btn-primary btn-block'])!!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="footer">
        <p>E-Mail: admin@gmail.com
        password: 123456</p>
        Copyright &copy; Your Company 2017
    </div>
@endsection

