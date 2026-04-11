{{--  @extends('admin.main')  --}}

@php
    use App\Helpers\template as Template;
    use App\Helpers\Form as FormTemplate;

    $nameVi           = (isset($item['name']))? $item->name : '';
    $descriptionVi    = (isset($item['description']))? $item->description : '';

    $formlabelAttr     = Config::get('zvn.template.form_label');
    $formInputAttr     = Config::get('zvn.template.form_input');

    $elements   = [
        [
            'label'     =>  Form::label('name', 'Tên', $formlabelAttr),
            'element'   =>  Form::text('name-vi', $nameVi,   $formInputAttr)
        ],
        [
            'label'     =>  Form::label('description', 'Miêu tả',$formlabelAttr),
            'element'   =>  Form::text('description-vi', $descriptionVi ,  $formInputAttr)
        ]
    ];

@endphp


<div class="tab-pane fade show active in" id="form-vi" role="tabpanel" aria-labelledby="home-tab">
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
</div>
