
@php
$accoutSidebar = [
                    [
                        'route' => 'authsphone/accountForm',
                        'name' => 'Thông tin tài khoản'
                    ],
                    [
                        'route' => 'authsphone/orderHistory',
                        'name' => 'Lịch sử mua hàng'
                    ],
                    [
                        'route' => 'authsphone/logout',
                        'name' => 'Đăng xuất'
                    ]
                ];
  $xhmlAccoutSidebar = '';
  foreach($accoutSidebar as $element){
    $activeClass = ($active == $element['route']) ? 'active' : '';
    $router = route($element['route']);
    $xhmlAccoutSidebar .='<li class="'.$activeClass.'"><a href="'.$router.'">'.$element['name'].'</a></li>';
  }
@endphp
<div class="col-lg-3">
    <div class="account-sidebar">
        <a class="popup-btn">Menu</a>
    </div>
    <h3 class="d-lg-none">Lịch sử mua hàng</h3>
    <div class="dashboard-left">
        <div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left"
                    aria-hidden="true"></i> Ẩn</span></div>
        <div class="block-content">
            <ul>
                {!! $xhmlAccoutSidebar !!}
            </ul>
        </div>
    </div>
</div>
