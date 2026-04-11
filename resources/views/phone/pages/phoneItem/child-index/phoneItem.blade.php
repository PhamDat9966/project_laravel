
@php
    use App\Helpers\Template;
    use Illuminate\Support\Str;

    $id   = $item['id'];
    $name = $item['name'];
    $description     = $item['description'];

    $saveTitle              = 0;
    $originalPriceDefault   = $item['attribute_prices'][0]['price'];
    $salePrice              = 0;

    //Data add to card button
    $dataColorIdDefault     = $item['attribute_prices'][0]['color_id'];
    $dataMaterialIdDefault  = $item['attribute_prices'][0]['material_id'];;
    $dataPriceDefault       = '';

    switch ($item['price_discount_type']) {
        case 'percent':
            $saveTitle = $item['price_discount_percent'];
            $salePrice = $originalPriceDefault - ($originalPriceDefault * $item['price_discount_percent']/100);
            break;
        case 'value':
            $saveTitle = '-'.$item['price_discount_value'].'$';
            $salePrice = $originalPriceDefault - $item['price_discount_value'];
            break;
    }
    $dataPriceDefault = $salePrice;
    $salePrice = ($salePrice == 0) ? 'Mẫu này đã hết hàng' : $salePrice . ' $';
    //Add to Cart button.
    $urlAddToCart     = route('authsphone/addToCart');
    $buttonAddCard    = '<a href="#" class="btn btn-solid ml-0 add-to-cart"
                                    data-id="'.$id.'"
                                    data-name="'.$name.'"
                                    data-color-id="'.$dataColorIdDefault.'"
                                    data-material-id="'.$dataMaterialIdDefault.'"
                                    data-url="'.$urlAddToCart.'"

                                    ><i class="fa fa-cart-plus"></i> Chọn mua
                        </a>';
    //End Add to Cart button.
    //media
    $imgArray        = json_decode($item['media'][0]['content'],true);
    $imgName         = $imgArray['name'];
    $imgAlt          = $imgArray['alt'];

    $image           = Template::showProductThumbInPhoneItem('product',$imgName,$imgAlt);
    $imageURL        = ($imgName)? asset("images/product/$imgName") : '';

    // Swiper
    $mediaSwiper     = '<div class="swiper mySwiper2">
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>

                            <div class="swiper-wrapper">';

    $thumbsSlider    = '<div thumbsSlider="" class="swiper mySwiper mt-2">
                            <div class="swiper-wrapper">';
    foreach($item['media'] as $media){
        $content      = json_decode($media['content']);
        $nameImg      = $content->name;

        $imageUrl     =  asset("images/product/$nameImg");

        $mediaSwiper .=             '<div class="swiper-slide">
                                        <img src="'.$imageUrl.'" class="img-fluid" />
                                    </div>';

        $thumbsSlider .=            '<div class="swiper-slide">
                                        <img src="'.$imageUrl.'" class="img-thumbnail" />
                                    </div>';
    }

    $mediaSwiper     .=     '</div>
                        </div>';
    $thumbsSlider     .=     '</div>
                        </div>';
    //dd($mediaGallery);
    //end Swiper


    $xhtmlColors     = '<div>';
    $xhtmlStorage    = '<ul class="list-inline prod_size display-layout">';
    $urlPrice        = route($controllerName.'/price');
    foreach($item['attributes'] as $key=>$attributeItem){
        //Nhóm các thuộc tính màu sắc thành một nhóm checkbox riêng
        $checked = ($key == 0) ? 'checked':'';
        if($attributeItem['attribute_id'] == 1 || $attributeItem['type'] == 'color'){
            $colorDiv     = Template::colorDivSmartPhone($attributeItem['attribute_value_id'],$attributeItem['attribute_value_name']);
            $urlCheckColor = route($controllerName.'/checkImage');
            $xhtmlColors .='<div class="form-check">
                                <input class="form-check-input" type="radio"
                                        data-id-product="'.$id.'"
                                        data-url="'.$urlCheckColor.'"
                                        data-id-color="'.$attributeItem['attribute_value_id'].'"
                                        name="color"
                                        id="color-'.$attributeItem['attribute_value_id'].'"
                                        value="'.$attributeItem['attribute_value_id'].'" '.$checked.'>

                                <label class="form-check-label mr-1" for="exampleRadios1">
                                    '.$colorDiv.'
                                </label>
                            </div>';
        }

        if($attributeItem['attribute_id'] == 2 || $attributeItem['type'] == 'material'){
            $xhtmlStorage .='<li>
                                <button type="button" class="btn btn-default btn-lg btn-material selected border border-secondary"
                                                      data-item-id="'.$id.'"
                                                      data-material-id="'.$attributeItem['attribute_value_id'].'"
                                                      data-url="'.$urlPrice.'"
                                                      data-sale-type="'.$item['price_discount_type'].'"
                                                      data-sale-percent="'.$item['price_discount_percent'].'"
                                                      data-sale-value="'.$item['price_discount_value'].'"
                                                      >'
                                                      .$attributeItem['attribute_value_name'].'
                                </button>
                            </li>';
        }

    }
    $xhtmlColors     .= '</div>';
    $xhtmlStorage    .= '</ul>';

@endphp
<div class="col-lg-9 col-sm-12 col-xs-12">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="filter-main-btn mb-2"><span class="filter-btn"><i class="fa fa-filter" aria-hidden="true"></i> filter</span></div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-7 col-xl-7">
                    {{-- {!! $image !!} --}}
                    {!! $mediaSwiper !!}
                    {!! $thumbsSlider !!}
            </div>
            <div class="col-lg-5 col-xl-5 rtl-text">
                <div class="product-right">
                    <h2 class="mb-2">{{$name}}</h2>
                    <h4 class="mb-2">Chọn màu sắc:</h4>
                    <div>
                        {!! $xhtmlColors !!}
                    </div>
                    <h4 class="my-2">Dung lượng:</h4>
                    <div class="mb-4">
                        {!! $xhtmlStorage !!}
                    </div>

                    <h4 class="my-2 border-product price-original">Giá:<del>{{$originalPriceDefault}} $</del><span> -{{$saveTitle}}%</span></h4>
                    <h3 class="price">{{$salePrice}}</h3>

                    <div class="product-buttons">
                        {!! $buttonAddCard !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <section class="tab-product m-0">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="top-home-tab"
                                data-toggle="tab" href="#top-home" role="tab"
                                aria-selected="true">Mô tả sản phẩm</a>
                            <div class="material-border"></div>
                        </li>
                    </ul>
                    <div class="tab-content nav-material" id="top-tabContent">
                        <div class="tab-pane fade show active ckeditor-content" id="top-home"
                            role="tabpanel" aria-labelledby="top-home-tab">

                            {!! $description !!}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

