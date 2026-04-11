@php
    use App\Helpers\URL;

    $request = Request::capture();
    global $host;
    $host = $request->getHost();
    $host = 'http://'.$host;

    $nameBreadcrumb   = '';
    $xhtmlBreadcrumbs = '';
    $linkCategory     = '';
    $linkBreadcrumbs  = '';


    if($item['translations']){
        foreach($item['translations'] as $keyT=>$translation){
            $nameBreadcrumb     = $translation['name'];
            $linkCategory       = URL::linkCategoryArticle($item['category_id'],$item['category_name']);

            $xhtmlBreadcrumbs   = '<ul class="d-flex flex-row align-items-start justify-content-start">';
            $xhtmlBreadcrumbs  .=       '<li><a href="'.route('home').'">Trang chủ</a></li>';
            foreach ($breadcrumbs as $valueBreadcrumb) {
                $linkBreadcrumbs   =    $host . '/' . $valueBreadcrumb['slug'] . '.php';
                $xhtmlBreadcrumbs .=    '<li><a href="'.$linkBreadcrumbs.'">'. $valueBreadcrumb['name'] .'</a></li>';
            }
            $xhtmlBreadcrumbs     .=    '<li>'.$nameBreadcrumb.'</li>';
            $xhtmlBreadcrumbs  .= '</ul>';
        }

    }else{
        $nameBreadcrumb     = $item['name'];
        $linkCategory       = URL::linkCategoryArticle($item['category_id'],$item['category_name']);

        $xhtmlBreadcrumbs   = '<ul class="d-flex flex-row align-items-start justify-content-start">';
        $xhtmlBreadcrumbs  .=       '<li><a href="'.route('home').'">Trang chủ</a></li>';
        foreach ($breadcrumbs as $valueBreadcrumb) {
            $linkBreadcrumbs   =    $host . '/' . $valueBreadcrumb['slug'] . '.php';
            $xhtmlBreadcrumbs .=    '<li><a href="'.$linkBreadcrumbs.'">'. $valueBreadcrumb['name'] .'</a></li>';
        }
        $xhtmlBreadcrumbs     .=    '<li>'.$nameBreadcrumb.'</li>';
        $xhtmlBreadcrumbs  .= '</ul>';
    }
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
