@php
    use App\Helpers\ProductHelper;

    $xhtml = '<div class="product-wrapper-grid" id="my-product-list">
                <div class="row margin-res">';
    foreach($items as $key=>$item){
        $xhtml .=   '<div class="col-xl-3 col-6 col-grid-box">';
        $xhtml .=       ProductHelper::xhtmlPhoneItem($item->toArray());
        $xhtml .=   '</div>';
    }

    $xhtml .='  </div>
            </div>';
@endphp

{!!$xhtml!!}

