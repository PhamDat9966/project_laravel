@php
    use App\Helpers\ProductHelper as ProductHelper;

    $xhmtRelated = '';
    foreach($productsRelated as $productRelated){
        $xhmtRelated .= '<div class="col-xl-2 col-md-4 col-sm-6">';
        $xhmtRelated .=     ProductHelper::xhtmlPhoneItem($productRelated);
        $xhmtRelated .= '</div>';
    }
@endphp
<section class="section-b-space j-box ratio_asos pb-0">
    <div class="container">
        <div class="row">
            <div class="col-12 product-related">
                <h2>Sản phẩm liên quan</h2>
            </div>
        </div>
        <div class="row search-product">
            {!! $xhmtRelated !!}
        </div>
    </div>
</section>
