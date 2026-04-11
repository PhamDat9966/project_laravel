@php
    $thumb02 = asset("images/phonetheme/icon/2.png");
    $img02 = '<li class="my-layout-view" data-number="2">
                <img src="'.$thumb02.'" alt=""
                    class="product-2-layout-view">
            </li>';

    $thumb03 = asset("images/phonethemeicon/3.png");
    $img03 = '<li class="my-layout-view" data-number="3">
                <img src="'.$thumb03.'" alt=""
                    class="product-3-layout-view">
            </li>';

    $thumb04 = asset("images/phonetheme/icon/4.png");
    $img04 = '<li class="my-layout-view" data-number="4">
                <img src="'.$thumb04.'" alt=""
                    class="product-4-layout-view">
            </li>';

    $thumb06 = asset("images/phonetheme/icon/6.png");
    $img06 = '<li class="my-layout-view" data-number="6">
                <img src="'.$thumb06.'" alt=""
                    class="product-6-layout-view">
            </li>';

    $arrSort    = config('zvn.template.smart_phone_category_sort');
    $filterSort = '<form action="" id="sort-form" method="GET">
                        <select id="sort" name="sort">';
    foreach($arrSort as $key=>$sort){
        $active          = ($params['sort']['price'] == $key) ? 'selected' : '';
        $filterSort     .= '<option value="'.$key.'" '.$active.'> '.$sort.' </option>';
    }

    $filterSort .=      '</select>
                    </form>';
@endphp
<div class="product-top-filter">
    <div class="row">
        <div class="col-xl-12">
            <div class="filter-main-btn">
                <span class="filter-btn btn btn-theme"><i class="fa fa-filter"
                        aria-hidden="true"></i> Filter</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="product-filter-content">
                <div class="collection-view">
                    <ul>
                        <li><i class="fa fa-th grid-layout-view"></i></li>
                        <li><i class="fa fa-list-ul list-layout-view"></i></li>
                    </ul>
                </div>
                <div class="collection-grid-view">
                    <ul>
                        {!! $img02 !!}
                        {!! $img03 !!}
                        {!! $img04 !!}
                        {!! $img06 !!}
                    </ul>
                </div>
                <div class="product-page-filter">
                   {!! $filterSort !!}
                </div>
            </div>
        </div>
    </div>
</div>
