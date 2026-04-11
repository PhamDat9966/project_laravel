@php
    use App\Helpers\template as Template;
    use App\Helpers\Form as FormTemplate;

    $formlabelAttr     = Config::get('zvn.template.form_label');
    $formInputAttr     = Config::get('zvn.template.form_input');

    $statusValue        = [
                                'default'    => Config::get('zvn.template.status.all.name'),
                                'active'     => Config::get('zvn.template.status.active.name'),
                                'inactive'   => Config::get('zvn.template.status.inactive.name')
                          ];
    $roleValue        = [
                            'default'   => 'Select Role'
                        ];

    foreach($roleList as $role){
        $roleValue[$role['id']] = Config::get('zvn.template.role.'.$role['name'].'.name');
    }
    // Dồn các thẻ thành 1 mảng, chuyển các class lặp lại vào zvn.php rồi dùng config::get để lấy ra
    $elements   = [
        [
            'label'     =>  Form::label('username', 'Username', $formlabelAttr),
            'element'   =>  Form::text('username', null ,$formInputAttr)  // Với collective trong mảng này chính là các thuộc..
                                                                                                    // ..tính như class, id , name của thẻ input
        ],
        [
            'label'     =>  Form::label('fullname', 'Fullname',$formlabelAttr),
            'element'   =>  Form::text('fullname', null , $formInputAttr)
        ],
        [
            'label'     =>  Form::label('email', 'Email',$formlabelAttr),
            'element'   =>  Form::text('email', null , $formInputAttr)
        ],
        [
            'label'     =>  Form::label('password', 'Password',$formlabelAttr),
            'element'   =>  Form::password('password', $formInputAttr)
        ],
        [
            'label'     =>  Form::label('password_confirmation', 'Password_confirmation',$formlabelAttr),
            'element'   =>  Form::password('password_confirmation', $formInputAttr)
        ],
        [
            'label'     =>  Form::label('role', 'Role', $formlabelAttr),
            'element'   =>  Form::select('roles_id', $roleValue, 'default', $formInputAttr)
        ],
        [
            'label'     =>  Form::label('status', 'Status', $formlabelAttr),
            'element'   =>  Form::select('status', $statusValue , 'default' , $formInputAttr)
            //Chú thích form::select(name,array Input for select, giá trị select ban đầu mặc định là default nếu rỗng, class)
        ],
        [
            'label'     =>  Form::label('avatar', 'Avatar', $formlabelAttr),
            'element'   =>  Form::file('avatar',  $formInputAttr),
            'type'      =>  'thumb',
            'thumb'     =>  (!empty($item['id'])) ? Template::showItemThumb($controllerName, $avatar , $username) : ''
        ],
        [
            'element'   =>  Form::submit('Save',['class'=>'btn btn-success','task'=>'taskAdd']),
            'type'      =>  'btn-submit'
        ]

    ];

@endphp

<!--box-lists-->
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin.templates.x_title',['title'=>'Form'])
            <!-- x Content -->
            <div class="x_content" style="display: block;">
                {!! Form::open([
                        'url'               =>  Route($controllerName.'/save'),
                        'method'            =>  'POST',
                        'accept-charset'    =>  'UTF-8',
                        'enctype'           =>  'multipart/form-data',
                        'class'             =>  'form-horizontal form-label-left',
                        'id'                =>  'main-form'
                    ]) !!}

                    {!! FormTemplate::show($elements)!!}
                {!! Form::close() !!}
            </div>
            <!-- end x Content -->
        </div>
    </div>
</div>

<!-- /page content -->
