@php
    use App\Helpers\template as Template;
    use App\Helpers\Form as FormTemplate;
    use Illuminate\Http\Request;

    $request = Request::capture();
    global $host;
    $host = $request->getHost();
    $host = 'http://'.$host;

    $logo               = (isset($item->logo))? $item->logo : '';
    $logoUrl            = (!empty($logo)) ? $host . $logo : '';
    $hotline            = (isset($item->hotline))? $item->hotline : '';
    $timeword           = (isset($item->timeword))? $item->timeword : '';
    $copyright          = (isset($item->copyright))? $item->copyright : '';
    $address            = (isset($item->address))? $item->address : '';
    $introduction       = (isset($item->introduction))? $item->introduction : '';
    $googlemap          = (isset($item->googlemap))? $item->googlemap : '';

    $formlabelAttr     = Config::get('zvn.template.form_label');
    $formInputAttr     = Config::get('zvn.template.form_input');
    $formCkeditorAttr  = Config::get('zvn.template.form_ckeditor');

    $statusValue       = [
                                'default'    => Config::get('zvn.template.status.all.name'),
                                'active'     => Config::get('zvn.template.status.active.name'),
                                'inactive'   => Config::get('zvn.template.status.inactive.name')
                          ];

    $inputLogoImage     = '<div class="input-group">
                                <span class="input-group-btn">
                                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                    <i class="fa fa-picture-o"></i> Choose
                                    </a>
                                </span>
                                <input id="thumbnail" class="form-control" type="text" name="logo" value="'.$logo.'">
                            </div>
                            <img id="holder" style="margin-top:15px;max-height:100px;" src="'.$logoUrl.'">';
                            //input value của input quyết định xem đường dẫn của ảnh
                            //image src quyet định hình ảnh ở vị trí nào, nếu không xuất ảnh để giá trị rỗng
    $elements   = [
        [
            'label'     =>  Form::label('logo', 'Logo', $formlabelAttr),
            'element'   =>  $inputLogoImage
        ],
        [
            'label'     =>  Form::label('hotline', 'Hotline', $formlabelAttr),
            'element'   =>  Form::text('hotline', $hotline, $formInputAttr)  // Với collective trong mảng này chính là các thuộc tính như class, id , name của thẻ input
        ],
        [
            'label'     =>  Form::label('timeword', 'Thời gian làm việc', $formlabelAttr),
            'element'   =>  Form::text('timeword', $timeword, $formInputAttr)  // Với collective trong mảng này chính là các thuộc tính như class, id , name của thẻ input
        ],
        [
            'label'     =>  Form::label('copyright', 'Copyright', $formlabelAttr),
            'element'   =>  Form::text('copyright', $copyright, $formInputAttr)
        ],
        [
            'label'     =>  Form::label('address', 'Address', $formlabelAttr),
            'element'   =>  Form::text('address', $address, $formInputAttr)
        ],
        [
            'label'     =>  Form::label('introduction', 'Giới thiệu',$formlabelAttr),
            'element'   =>  Form::textarea('introduction', $introduction, $formCkeditorAttr)
        ],
        [
            'label'     =>  Form::label('googlemap', 'Google Maps',$formlabelAttr),
            'element'   =>  Form::textarea('googlemap', $googlemap, $formInputAttr)
        ],
        [
            'element'   =>  Form::submit('Save',['class'=>'btn btn-success','name'=>'taskGeneral']),
            'type'      =>  'btn-submit'
        ]

    ];



@endphp
<div class="tab-pane fade show active in" id="home" role="tabpanel" aria-labelledby="home-tab">
    <!-- x Content -->
    <div class="x_content" style="display: block;">
        {{-- Thẻ Form::open chính là thẻ form trong html với nhiều thuộc tính hơn, lấy từ đối tượng Collective --}}
        {!! Form::open([
                'url'               =>  Route($controllerName.'/saveGeneral'),
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
