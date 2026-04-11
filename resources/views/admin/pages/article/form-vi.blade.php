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
    $contentVi      = (isset($item['content']))? $item->content : '';

    $formlabelAttr     = Config::get('zvn.template.form_label');
    $formInputAttr     = Config::get('zvn.template.form_input');
    $formCkeditorAttr  = Config::get('zvn.template.form_ckeditor');

    $inputNameArticle  = '<input class="form-control col-md-6 col-xs-12"
                                 name="name-vi"
                                 type="text"
                                 value="' . htmlspecialchars($nameVi, ENT_QUOTES, 'UTF-8') . '"
                                 id="name_article-vi"
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
            'element'   =>  $inputNameArticle                            // Với collective trong mảng này chính là các thuộc..
                                                                                                    // ..tính như class, id , name của thẻ input
        ],
        [
            'label'     =>  Form::label('slug', 'Slug', $formlabelAttr),
            'element'   =>  $inputSlugVi
        ],
        [
            'label'     =>  Form::label('content', 'Nội dung',$formlabelAttr),
            'element'   =>  Form::textarea('content-vi', $contentVi, $formInputAttr + ['id' => 'ckeditor-vn'])
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

<script src="{{asset('admin/js/ckeditor/ckeditor.js')}}"></script>
<script>
    // Khởi tạo CKEditor, tích hợp với Laravel file manager với những input textarea có id = 'ckeditor' hoặc id = 'content'
    CKEDITOR.replace('ckeditor-vn', {
        filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
        filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{ csrf_token() }}',
        filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
        filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{ csrf_token() }}'
    });
</script>
