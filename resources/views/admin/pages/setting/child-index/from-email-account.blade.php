@php
    use App\Helpers\template as Template;
    use App\Helpers\Form as FormTemplate;

    $formlabelAttr     = Config::get('zvn.template.form_label');
    $formInputAttr     = Config::get('zvn.template.form_input');
    $formCkeditorAttr  = Config::get('zvn.template.form_ckeditor');

    $username             = (isset($item->username))? $item->username : '';
    $password             = (isset($item->password))? $item->password : '';

    // Dồn các thẻ thành 1 mảng, chuyển các class lặp lại vào zvn.php rồi dùng config::get để lấy ra
    $elements   = [
        [
            'label'     =>  Form::label('username', 'Tài khoảng', $formlabelAttr),
            'element'   =>  Form::text('username', $username,   $formInputAttr)  // Với collective trong mảng này chính là các thuộc..
                                                                                                    // ..tính như class, id , name của thẻ input
        ],
        [
            'label'     =>  Form::label('password', 'Mật khẩu', $formlabelAttr),
            'element'   =>  Form::text('password',$password,$formInputAttr)  // Với collective trong mảng này chính là các thuộc..
                                                                                                    // ..tính như class, id , name của thẻ input
        ],
        [
            'element'   =>  Form::submit('Save',['class'=>'btn btn-success','name'=>'taskEmailAccount']),
            'type'      =>  'btn-submit'
        ]

    ];

@endphp
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="tab-pane fade show active in" id="email" role="tabpanel" aria-labelledby="home-tab">
                <!-- x Content -->
                <div class="x_content" style="display: block;">
                    {{-- Thẻ Form::open chính là thẻ form trong html với nhiều thuộc tính hơn, lấy từ đối tượng Collective --}}
                    {!! Form::open([
                            'url'               =>  Route($controllerName.'/saveEmail'),
                            'method'            =>  'POST',
                            'accept-charset'    =>  'UTF-8',
                            'enctype'           =>  'multipart/form-data',
                            'class'             =>  'form-horizontal form-label-left',
                            'id'                =>  'main-form'
                        ]) !!}

                        {!! FormTemplate::show($elements)!!}

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
