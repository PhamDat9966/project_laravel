@php
    $adTitle = ($locale == 'en') ? 'Advertising' : 'Quảng cáo';
    $sub     = ($locale == 'en') ? 'Buy online now' : 'Mua online ngay bây giờ';
@endphp
<!-- Extra -->
<div class="sidebar_extra">
    <a href="#">
        <div class="sidebar_title">{{ $adTitle }}</div>
        <div class="sidebar_extra_container">
            <div class="background_image"
                 style="background-image:url({!!asset('news/images/extra_1.jpg')!!}"></div>
            <div class="sidebar_extra_content">
                <div class="sidebar_extra_title">30%</div>
                <div class="sidebar_extra_title">off</div>
                <div class="sidebar_extra_subtitle">{{ $sub }}</div>
            </div>
        </div>
    </a>
</div>
