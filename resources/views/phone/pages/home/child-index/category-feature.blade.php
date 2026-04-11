@php
    use App\Helpers\Template;
    use Illuminate\Support\Str;
    use App\Helpers\ProductHelper;

    $xhtmlTabTitle  = '<ul class="tabs tab-title">';

    $xhtmlTabContent = '<div class="tab-content-cls">';
    $i = 1;

    foreach($categoryIsFeatures as $keyCa=>$categoryIsFeature){
        $id               = $categoryIsFeature['id'];
        $tagTitleCurrent  = '';
        $tagContentActive = '';
        if($i==1){
            $tagTitleCurrent    = 'current';
            $tagContentActive   = 'active default';
        }

        $xhtmlTabTitle .= '<li class="'.$tagTitleCurrent.'"><a href="tab-category-'.$i.'" class="my-product-tab" data-category="'.$i.'">'.$categoryIsFeature['name'].'</a></li>';
        $xhtmlTabContent   .='<div id="tab-category-'.$i.'" class="tab-content '.$tagContentActive.'">
                                <div class="no-slider row tab-content-inside">';

        foreach($categoryIsFeature['items'] as $keyItem=>$item){
            $xhtmlTabContent .= ProductHelper::xhtmlPhoneItem($item);// Tối ưu hóa, đưa item vào một lớp sử lý chung.
        }

        $urlCategory      = route('phoneCategory',['id'=>$id]);

        $xhtmlTabContent .= '</div>
                                <div class="text-center"><a href="'.$urlCategory.'" class="btn btn-solid">Xem tất cả</a></div>
                            </div>';

        $i++;
    }
    $xhtmlTabContent .='</div>';

    $xhtmlTabTitle .= '</ul>';
    //dd($xhtmlTabContent);
@endphp
<div class="title1 section-t-space title5">
    <h2 class="title-inner1">Danh mục nổi bật</h2>
    <hr role="tournament6">
</div>
<section class="p-t-0 j-box ratio_asos">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="theme-tab">
                    {!!
                       $xhtmlTabTitle
                    !!}

                    {!!$xhtmlTabContent!!}
                </div>
            </div>
        </div>
    </div>
</section>
