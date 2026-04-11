{{--  @extends('admin.main')  --}}

@php
    use App\Helpers\template as Template;
    use App\Helpers\Form as FormTemplate;

    $request = Request::capture();
    global $host;
    $host = $request->getHost();
    $host = 'http://'.$host;

    $nameVi         = (isset($item['name']))? $item->name : '';
    $slugVi         = (isset($item['slug']))? $item->slug : '';

    $formlabelAttr     = Config::get('zvn.template.form_label');
    $formInputAttr     = Config::get('zvn.template.form_input');
    $formCkeditorAttr  = Config::get('zvn.template.form_ckeditor');

    $inputNameArticle  = '<input class="form-control col-md-6 col-xs-12"
                                 name="name-vi"
                                 type="text"
                                 value="' . htmlspecialchars($nameVi, ENT_QUOTES, 'UTF-8') . '"
                                 id="category_article_vi"
                                 data-auto-increment="'.$autoIncrement.'"
                          >';
    $inputSlugVi      = '<input  class="form-control col-md-6 col-xs-12"
                                    name="slug-vi"
                                    type="text"
                                    id="slug-vi"
                                    value="'.$slugVi.'"
                        >';

    // Dồn các thẻ thành 1 mảng, chuyển các class lặp lại vào zvn.php rồi dùng config::get để lấy ra
    $elements   = [
        [
            'label'     =>  Form::label('name', 'Tên', $formlabelAttr),
            'element'   =>  $inputNameArticle
        ],
        [
            'label'     =>  Form::label('slug', 'Slug', $formlabelAttr),
            'element'   =>  $inputSlugVi
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
