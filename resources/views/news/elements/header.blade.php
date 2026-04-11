@php
    use App\Helpers\MenuNews as MenuNews;
    use App\Models\CategoryArticleModel as CategoryArticleModel;
    use App\Models\ArticleModel as ArticleModel;
    use App\Models\MenuModel as MenuModel;

    use App\Models\SettingModel as SettingModel;
    use Illuminate\Support\Facades\App;

    $menuNewsHelper = new MenuNews();
    $request = Request::capture();
    global $host;
    $host = $request->getHost();
    $host = 'http://'.$host;
    $prefixNews     = config('zvn.url.prefix_news');
    if($prefixNews != null){
        $host = $host.'/'.$prefixNews;
    }

    $params = [];
    $locale             = App::getLocale();
    $params['locale']   = (isset($locale)) ? $locale : 'vi';
    $MenuModel      = new MenuModel();
    //$itemsMenu      = $MenuModel->listItems($params,['task'=>'news-list-items-navbar-menu']);
    $itemsMenu      = $MenuModel->listItems($params,['task'=>'news-list-items-navbar-menu-with-locale']);

    $xhtmlMenu          = '';
    $xhtmlMenuMobile    = '';

    $xhtmlMenu  .= '<nav class="main_nav"><ul class="main_nav_list d-flex flex-row align-items-center justify-content-start">';
    // $xhtmlMenuMobile  .= '<nav class="menu_nav"><ul class="menu_mm">';

    // Gọi hàm đệ quy để tạo menu từ mảng
    $xhtmlMenu .= $menuNewsHelper->buildMenu($itemsMenu, null, null, $params['locale']);

    $loginChar  = 'Đăng nhập';
    $logoutChar = 'Thoát';
    if($params['locale'] == 'en'){
        $loginChar  = 'Login';
        $logoutChar = 'Logout';
    }
    $xhtmlMenuUser      = sprintf('<li><a href="%s">%s</a></li>',route('auth/login'),$loginChar);
    if(session('userInfo')){
        $xhtmlMenuUser  = sprintf('<li><a href="%s">%s</a></li>',route('auth/logout'),$logoutChar);
    }

    $viFlag     = '/images/flags/vn.png';
    $enFlag     = '/images/flags/us.png';

    $langVI  = sprintf('<a href="#" class="lang-btn" title="Tiếng Việt" id="btn-vi">
                                    <img src="%s" alt="VI">
                                </a>',$viFlag);
    $langEn  = sprintf('<a href="#" class="lang-btn" title="Tiếng Anh" id="btn-en">
                                    <img src="%s" alt="En">
                                </a>',$enFlag);


    $multiLang           = '<li>'.$langVI.$langEn.'</li>';


    $xhtmlMenu          .= $xhtmlMenuUser.$multiLang.'</ul></nav>';
    $xhtmlMenuMobile    .= $xhtmlMenuUser.$multiLang.'</ul></nav>';

    //--end navbar--//

    //--logo--//
    $logo ='<span>ZEND</span>VN</div>';
    $settingModel = new SettingModel();
    $setting = $settingModel->getItem(null,['task'=>'get-all-items']);

    if(!empty($setting)){
        foreach ($setting as $value) {
            if($value['key_value'] == 'setting-general'){
                $valueTemp = json_decode($value['value']);
                $valueLogo = $valueTemp->logo;
                $logo      = $host . $valueLogo;
            }
            break;
        }
    }
    //--end logo--//
@endphp
<header class="header">
    <!-- Header Content -->
    <div class="header_content_container">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <div class="header_content d-flex flex-row align-items-center justfy-content-start mt-3">
                        <div class="logo_container" style="height: 100px;">
                            <a href="{!! route('home') !!}">
                                {{-- <div class="logo"><span>ZEND</span>VN</div> --}}
                                <div class="logo"><img class="w-100 logosize" style="height:auto" src="{{$logo}}" alt="Logo"></div>
                            </a>
                        </div>
                    </div>
                </div>
                @php
                    $phoneNumber = 'Điện thoại liên hệ';
                    $appointment = 'Đặt lịch hẹn';
                    if($locale == 'en'){
                        $phoneNumber = 'Contact phone';
                        $appointment = 'Make an appointment';
                    }
                @endphp
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="header_extra ml-auto d-flex flex-row align-items-center justify-content-center">
                        <a href="#">
                            <div class="background_image"
                                    style="background-image:url({!!asset('news/images/zendvn-online.png')!!});background-size: contain"></div>
                        </a>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                            <i class="fa fa-phone" aria-hidden="true"></i>  {{$phoneNumber}}
                        </button>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <div class="flex-row align-items-center mt-3">
                        <!-- Phone liên hệ -->
                        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#exampleModal">
                            <i class="fa fa-phone" aria-hidden="true"></i>  {{$phoneNumber}}
                        </button>
                        <a class="btn btn-danger btn-block" href="{!! route('appointmentnews',['locale'=>$locale]) !!}" role="button">
                            <i class="fa fa-calendar" aria-hidden="true"></i>  {{$appointment}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header Navigation & Search -->
    <div class="header_nav_container" id="header">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="header_nav_content d-flex flex-row align-items-center justify-content-start">
                        <!-- Logo -->
                        <div class="logo_container">
                            <a href="#">
                                <div class="logo"><span>ZEND</span>VN</div>
                            </a>
                        </div>
                        <!-- Navigation -->
                        {!! $xhtmlMenu !!}
                        <!-- Hamburger -->
                        <div class="hamburger ml-auto menu_mm"><i class="fa fa-bars  trans_200 menu_mm"
                                                                  aria-hidden="true"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Menu -->
<div class="menu d-flex flex-column align-items-end justify-content-start text-right menu_mm trans_400">
    <div class="menu_close_container">
        <div class="menu_close">
            <div></div>
            <div></div>
        </div>
    </div>
    {!!$xhtmlMenuMobile!!}
</div>

<!-- Đây là popup của box Phone liên hệ -->
<!-- Modal -->
@php
    $phoneContactUrl        = route('phonecontact',['locale'=>$locale]);
    $titlePhoneContact      = 'Liên hệ với chúng tôi';
    $contentPhoneContact    = 'Để lại số điện thoại của bạn để nhận cuộc gọi từ chúng tôi.';

    if($locale == 'en'){
        $titlePhoneContact      = 'Contact us';
        $contentPhoneContact    = 'Leave your phone number to receive a call from us.';
    }
    $reCAPTCHAsitekey = '6LfInD4rAAAAAKEX454J3YW6rWL4WhPyDwH5dRBd';

@endphp
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title font-weight-bold" id="exampleModalLabel">{{$titlePhoneContact}}</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="logo mb-3"><span>ZEND</span>VN</div>
        <h5 class="font-italic">{{$contentPhoneContact}}</h5>
        <div class="g-recaptcha" data-sitekey="6LfInD4rAAAAAKEX454J3YW6rWL4WhPyDwH5dRBd"></div>
        <input type="text" id="modal-phone-input" class="form-control" placeholder="Số điện thoại của bạn" data-url="{{$phoneContactUrl}}" data-locale="{{$locale}}">
        {{-- Đây là nơi xuất thông báo lỗi --}}
        <p class="text-danger"></p>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
        <button type="button" class="btn btn-primary" id="submitModal">Liên hệ</button>
    </div>
    </div>
</div>
</div>
