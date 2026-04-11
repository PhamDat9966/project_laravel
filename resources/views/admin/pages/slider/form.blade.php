@extends('admin.main')

@section('content')
    <!-- page content -->
    @include('admin.templates.page_header', ['pageIndex' => false])

    @include('admin.templates.error')
    @php
        $itemEn = [];
        if(isset($item)){
            foreach($item['translations'] as $itemTrans){
                if($itemTrans['locale'] == 'en'){
                    $itemEn = $itemTrans;
                    break;
                }
            }
        }
    @endphp
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_content">
                <ul class="nav nav-tabs bar_tabs" id="myTab" role="tablist">
                    <li class="nav-item active">
                        <a class="nav-link active" id="formvn-tab" data-toggle="tab" href="#formvn" role="tab" aria-controls="formvn" aria-selected="true">Tiếng Việt</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="formen-tab" data-toggle="tab" href="#formen" role="tab" aria-controls="formen" aria-selected="false">English</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active in" id="formvn" role="tabpanel" aria-labelledby="formvn-tab">
                        @include('admin.pages.slider.form-vi')
                    </div>
                    <div class="tab-pane fade" id="formen" role="tabpanel" aria-labelledby="formen-tab">
                        @include('admin.pages.slider.form-en',['itemEn'=>$itemEn])
                    </div>
                </div>
                @include('admin.pages.slider.form-merged')
            </div>
        </div>
    </div>

@endsection

@section('after_script')
    {{--  <script src="{{asset('admin/js/ckeditor/ckeditor.js')}}"></script>  --}}
    <script>
        // Khởi tạo CKEditor, tích hợp với Laravel file manager với những input textarea có id = 'ckeditor' hoặc id = 'content'
        {{--  CKEDITOR.replace('ckeditor', {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{ csrf_token() }}',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{ csrf_token() }}'
        });  --}}
        {{--  CKEDITOR.replace('content', {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{ csrf_token() }}',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{ csrf_token() }}'
        });  --}}

    </script>
@endsection
