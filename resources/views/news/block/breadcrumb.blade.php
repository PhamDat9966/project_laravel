@php
    $request = Request::capture();
    global $host;

    $homeText = 'Trang chủ';
    if($locale == 'en') $homeText = 'Home';

    $host = $request->getHost();
    $host = 'http://'.$host;
    $nameBreadcrumb = $item['name'];

    $xhtmlBreadcrumbs   = '<ul class="d-flex flex-row align-items-start justify-content-start">';
    $xhtmlBreadcrumbs  .=       '<li><a href="'.route('home')."/$locale/".'">'.$homeText.'</a></li>';
    if(isset($breadcrumbs)){
        foreach ($breadcrumbs as $valueBreadcrumb) {
            $linkBreadcrumbs   =    $host . "/$locale/" . $valueBreadcrumb['slug'] . '.php';
            $xhtmlBreadcrumbs .=    '<li><a href="'.$linkBreadcrumbs.'">'. $valueBreadcrumb['name'] .'</a></li>';
        }
    }else{
        $xhtmlBreadcrumbs .=    '<li><a href="">'. $nameBreadcrumb .'</a></li>';
    }
    $xhtmlBreadcrumbs  .= '</ul>';
@endphp
<div class="home">
    <div class="parallax_background parallax-window" data-parallax="scroll" data-image-src="{{asset('news/images/footer.jpg')}}" data-speed="0.8"></div>
    <div class="home_content_container">
       <div class="container">
          <div class="row">
             <div class="col">
                <div class="home_content">
                   <div class="home_title">{{ $nameBreadcrumb }}</div>
                   <div class="breadcrumbs">
                        {!! $xhtmlBreadcrumbs !!}
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>
