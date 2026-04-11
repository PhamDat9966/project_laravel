@php
    use App\Helpers\template as Template;
    use App\Helpers\Form as FormTemplate;

    $id             = (isset($item['id']))? $item['id'] : '';
    $roles_id       = (isset($item['roles_id']))? $item->roles_id : '';

    $formlabelAttr     = Config::get('zvn.template.form_label_edit');
    $formInputAttr     = Config::get('zvn.template.form_input');
    $inputHiddenID     = Form::hidden('id' , $id);

    $roleValue        = [
                            'default'   => 'Select Role'
                        ];

    foreach($roleList as $role){
        $roleValue[$role['id']] = Config::get('zvn.template.role.'.$role['name'].'.name');
    }

    $primeID        = Config::get('zvn.config.lock.prime_id');

    // Dồn các thẻ thành 1 mảng, chuyển các class lặp lại vào zvn.php rồi dùng config::get để lấy ra
    $elements   = [
        [
            'label'     =>  Form::label('role', 'Role', $formlabelAttr),
            'element'   =>  ($roles_id != $primeID) ? Form::select('roles_id', $roleValue, $roles_id, $formInputAttr) : '<label class="control-label" style="color:blue">Locked</label>'
        ],
        [
            'element'   =>  $inputHiddenID . Form::submit('Save',['class'=>'btn btn-success','name'=>'taskChangeLevel']),
            'type'      =>  'btn-submit-edit'
        ]
    ];

@endphp
<div class="col-md-6 col-sm-12 col-xs-12">
    <div class="x_panel">
        @include('admin.templates.x_title',['title'=>'Quyền Truy Cập'])
        <!-- x Content -->
        <div class="x_content" style="display: block;">
            {!! Form::open([
                    'url'               =>  Route($controllerName.'/change-role-post'),
                    'method'            =>  'POST',
                    'accept-charset'    =>  'UTF-8',
                    'enctype'           =>  'multipart/form-data',
                    'class'             =>  'form-horizontal form-label-left',
                    'id'                =>  'main-form'
                ]) !!}
            {!! FormTemplate::show($elements)!!}
        </div>
        <!-- end x Content -->
    </div>
</div>

