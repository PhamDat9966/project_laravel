@extends('admin.main')

@php
    use App\Helpers\template as Template;
    use App\Helpers\Form as FormTemplate;

    $id             = (isset($item['id']))? $item['id'] : '';
    $name           = (isset($item['name']))? $item->name : '';
    $link           = (isset($item['link']))? $item->link : '';
    $ordering       = (isset($item['ordering']))? $item->ordering : '';
    $source         = (isset($item['source']))? $item->source : '';
    $status         = (isset($item['status']))? $item->status : '';

    // OR
    // $name           = (isset($item->name))? $item->name : '';
    // $description    = (isset($item->description))? $item->description : '';
    // $link           = (isset($item->link))? $item->link : '';
    // $status         = (isset($item->status))? $item->status : 'null';
    // $thumb          = (isset($item->thumb))? $item->thumb : 'null';

    // Đối tượng Form là của Collective
    // $nameLabel  =   Form::label('name', 'Name', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']);
    // $nameInput  =   Form::text('name', $name, ['class' => 'form-control col-md-6 col-xs-12','id'=>'name']);

    // $descriptionLabel   =   Form::label('description', 'Description', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']);
    // $descriptionInput   =   Form::text('description', $description , ['class' => 'form-control col-md-6 col-xs-12','id'=>'description']);

    $formlabelAttr     = Config::get('zvn.template.form_label');
    $formInputAttr     = Config::get('zvn.template.form_input');
    $inputHiddenID      = Form::hidden('id' , $id);

    $statusValue        = [
                                'default'    => Config::get('zvn.template.status.all.name'),
                                'active'     => Config::get('zvn.template.status.active.name'),
                                'inactive'   => Config::get('zvn.template.status.inactive.name')
                          ];

    // Dồn các thẻ thành 1 mảng, chuyển các class lặp lại vào zvn.php rồi dùng config::get để lấy ra
    $elements   = [
        [
            'label'     =>  Form::label('name', 'Name', $formlabelAttr),
            'element'   =>  Form::text('name', $name,   $formInputAttr)  // Với collective trong mảng này chính là các thuộc..
                                                                                                    // ..tính như class, id , name của thẻ input
        ],
        [
            'label'     =>  Form::label('link', 'Link',$formlabelAttr),
            'element'   =>  Form::text('link', $link , $formInputAttr)
        ],
        [
            'label'     =>  Form::label('ordering', 'Ordering',$formlabelAttr),
            'element'   =>  Form::text('ordering', $ordering , $formInputAttr)
        ],
        [
            'label'     =>  Form::label('source', 'Source',$formlabelAttr),
            'element'   =>  Form::text('source', $source , $formInputAttr)
        ],
        [
            'label'     =>  Form::label('status', 'Status', $formlabelAttr),
            'element'   =>  Form::select('status', $statusValue, $status, $formInputAttr)
            //Chú thích form::select(name,array Input for select, giá trị select ban đầu mặc định là default nếu rỗng, class)
        ],
        [
            'element'   =>  $inputHiddenID . Form::submit('Save',['class'=>'btn btn-success']),
            'type'      =>  'btn-submit'
        ]

    ];

@endphp

@section('content')
<!-- page content -->
@include('admin.templates.page_header', ['pageIndex' => false])

@include('admin.templates.error')

<!--box-lists-->
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin.templates.x_title',['title'=>'Form'])
            <!-- x Content -->
            <div class="x_content" style="display: block;">
                {{-- Thẻ Form::open chính là thẻ form trong html với nhiều thuộc tính hơn, lấy từ đối tượng Collective --}}
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
@endsection

