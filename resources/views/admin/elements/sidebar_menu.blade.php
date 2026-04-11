<!-- menu profile quick info -->
@php
    use Illuminate\Support\Facades\Session;
    use App\Helpers\Template as Template;
    use App\Models\PermissionModel;

    $userInfo = $value = Session::get('userInfo');
    $nameUser = ucfirst($userInfo['username']);
    $avatar   = Template::showAvatar($userInfo['avatar'],$userInfo['username']);
    $primeID  = config('zvn.config.lock.prime_id');

    $permissionModel    = new PermissionModel();
    $permissionsActive  = $permissionModel->getItem(null,['task'=>'get-item-name-and-id']);

    $user_has_permission_names      = array_column($userInfo['has_permission'], "permission_name");
    $all_permission_names_active    = array_column($permissionsActive, "name");

    //dd($user_has_permission_names,$all_permission_names_active);//word-wrap: break-word;white-space: pre-wrap;
@endphp
<div class="profile clearfix">
    <div class="profile_pic">
        <img src="{{asset('images/user/'.$userInfo['avatar'].'')}}" alt="..." class="img-circle profile_img">
    </div>
    <div class="profile_info">
        <span>Welcome,</span>
        <h2>{{$nameUser}}</h2>
    </div>
</div>
<!-- /menu profile quick info -->
<br/>
<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>Menu</h3>
        <ul class="nav side-menu">
            <li id="dashboard">
                <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i> Dashboard</a>
            </li>
            @if ($userInfo['roles_id'] == $primeID || in_array('access-user', $user_has_permission_names) && in_array('access-user', $all_permission_names_active))
                <li id="user">
                    <a href="{{ route('user')}}"><i class="fa fa-user"></i> User</a>
                </li>
            @endif
            @if($userInfo['roles_id'] == $primeID)
                <li id='permission'>
                    <a><i class="fa fa-institution"></i> Phân quyền<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{ route('role')}}"> Role - Vai trò</a></li>
                        <li><a href="{{ route('permission')}}"> Permission - Phân quyền</a></li>
                        <li><a href="{{ route('roleHasPermission')}}">Vai trò và Phân quyền</a></li>
                        <li><a href="{{ route('modelHasPermission')}}">Gán quyền trực tiếp cho User</a></li>
                    </ul>
                </li>
            @endif
            @if($userInfo['roles_id'] == $primeID || in_array('access-product', $user_has_permission_names) && in_array('access-product', $all_permission_names_active))
                <li id='product'>
                    <a><i class="fa fa-archive"></i> Quản lý Sản Phẩm<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{ route('product')}}"> Product</a></li>
                        <li><a href="{{ route('categoryProduct')}}"> Category - Menu đa cấp</a></li>
                        <li><a href="{{ route('productHasAttribute')}}"> Thuộc tính của sản phẩm</a></li>
                        <li><a href="{{ route('productAttributePrice')}}"> Giá của sản phẩm liên kết với cặp thuộc tính</a></li>
                        <li><a href="{{ route('productHasMedia')}}"> Media liên kết với thuộc tính mùa sắc của sản phẩm</a></li>
                    </ul>
                </li>
            @endif
            @if($userInfo['roles_id'] == $primeID || in_array('access-attribute', $user_has_permission_names) && in_array('access-attribute', $all_permission_names_active))
                <li id='attribute'>
                    <a><i class="fa fa-cubes"></i> Quản lý Thuộc tính Sản Phẩm<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{ route('attribute')}}"> Loại thuộc tính</a></li>
                        <li><a href="{{ route('attributevalue')}}"> Giá trị thuộc tính</a></li>
                    </ul>
                </li>
            @endif
            @if($userInfo['roles_id'] == $primeID || in_array('access-coupon', $user_has_permission_names) && in_array('access-coupon', $all_permission_names_active))
                <li><a href="{{ route('coupon')}}"><i class="fa fa-money"></i> Mã khuyến mãi</a></li>
            @endif
            @if($userInfo['roles_id'] == $primeID || in_array('access-article', $user_has_permission_names) && in_array('access-article', $all_permission_names_active))
                <li id='article'>
                    <a><i class="fa fa-newspaper-o"></i> Quản lý bài viết<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{ route('article')}}"> Article</a></li>
                        <li><a href="{{ route('categoryArticle')}}"> Category - menu đa cấp</a></li>
                    </ul>
                </li>
            @endif
            @if($userInfo['roles_id'] == $primeID || in_array('access-menu', $user_has_permission_names) && in_array('access-menu', $all_permission_names_active))
                {{-- <li><a href="{{ route('menu')}}"><i class="fa fa-sitemap"></i> Menu tổng quát</a></li> --}}
                <li id='menu'>
                    <a><i class="fa fa-sitemap"></i> Menu tổng quát<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{ route('menu')}}"> Tin tức</a></li>
                        <li><a href="{{ route('menuSmartPhone')}}"> Smart phone</a></li>
                    </ul>
                </li>
            @endif
            @if($userInfo['roles_id'] == $primeID || in_array('access-slider', $user_has_permission_names) && in_array('access-slider', $all_permission_names_active))
                <!-- <li><a href="{{ route('slider')}}"><i class="fa fa-sliders"></i> Sliders</a></li> -->
                <li id='slider'>
                    <a><i class="fa fa-sliders"></i> Quản lý Slider<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{ route('slider')}}"> Slider News</a></li>
                        <li><a href="{{ route('sliderPhone')}}"> Slider Phone</a></li>
                    </ul>
                </li>
            @endif
            @if($userInfo['roles_id'] == $primeID || (in_array('access-gallery', $user_has_permission_names) && in_array('access-gallery', $all_permission_names_active)) || (in_array('access-video', $user_has_permission_names) && in_array('access-video', $all_permission_names_active)))
                <li id='media' hidden="hidden">
                    <a><i class="fa fa-file-image-o"></i></i> Quản lý media<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{ route('gallery')}}"> Gallery</a></li>
                        <li><a href="{{ route('video')}}"> Playlist Youtube</a></li>
                    </ul>
                </li>
            @endif
            <li><a href="{{ route('changePassword')}}"><i class="fa fa-key"></i> Change Password</a></li>
            @if($userInfo['roles_id'] == $primeID || in_array('access-contact', $user_has_permission_names) && in_array('access-contact', $all_permission_names_active))
                <li><a href="{{ route('admin.contact')}}"><i class="fa fa-paper-plane"></i>Liên hệ</a></li>
            @endif
            @if($userInfo['roles_id'] == $primeID || in_array('access-phone', $user_has_permission_names) && in_array('access-phone', $all_permission_names_active))
                <li><a href="{{ route('phone')}}"><i class="fa fa-volume-control-phone"></i>Fast Phone</a></li>
            @endif
            @if($userInfo['roles_id'] == $primeID || in_array('access-setting', $user_has_permission_names) && in_array('access-setting', $all_permission_names_active))
                <li id='setting'>
                    <a><i class="fa fa-cog"></i> Setting<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{ route('setting',['type'=>'general'])}}">General</a></li>
                        <li><a href="{{ route('setting',['type'=>'email'])}}">Email</a></li>
                        <li><a href="{{ route('setting',['type'=>'social'])}}">Social</a></li>
                    </ul>
                </li>
            @endif
            @if($userInfo['roles_id'] == $primeID || in_array('access-rss', $user_has_permission_names) && in_array('access-rss', $all_permission_names_active))
                <li id='rss'>
                    <a><i class="fa fa-rss"></i> Quản lý Rss<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{ route('rss')}}"> Rss</a></li>
                        <li><a href="{{ route('rssnews')}}"> Rss News</a></li>
                    </ul>
                </li>
            @endif
            <li><a href="{{ route("admin.logs.index")}}"><i class="fa fa-history"></i> LogViewer</a></li>
            @if($userInfo['roles_id'] == $primeID || in_array('access-appointment', $user_has_permission_names) && in_array('access-appointment', $all_permission_names_active))
                <li><a href="{{ route('appointment')}}"><i class="fa fa-calculator"></i> Lịch hẹn</a></li>
            @endif
            <li><a href="{{ route('branch')}}"><i class="fa fa-suitcase"></i> Chi nhánh</a></li>
            @if($userInfo['roles_id'] == $primeID || in_array('access-userAgents', $user_has_permission_names) && in_array('access-userAgents', $all_permission_names_active))
                <li id='userAgents'>
                    <a><i class="fa fa-jsfiddle"></i> Quản lý views người dùng<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{ route('dataViewsArticle')}}"> Data Views</a></li>
                        <li><a href="{{ route('userAgents')}}"> UserAgents</a></li>
                    </ul>
                </li>
            @endif
            @if($userInfo['roles_id'] == $primeID || in_array('access-userAgents', $user_has_permission_names) && in_array('access-userAgents', $all_permission_names_active))
                <li id='orderHistory'>
                    <a href="{{ route('orderHistory') }}"><i class="fa fa-shopping-cart"></i> Lịch sử đơn hàng</a>
                </li>
            @endif
        </ul>
    </div>
</div>
<!-- /sidebar menu -->

