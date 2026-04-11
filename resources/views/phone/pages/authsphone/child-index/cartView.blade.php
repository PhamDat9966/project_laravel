@php
    // use App\Helpers\Template;
    $xhtml = '';
    $allTotalPriceProduct = 0;

    if($cart){
        foreach($cart as $key=>$item){
            $id                     = $product_id = $item['product_id'];
            $color_id               = $item['color_id'];
            $material_id            = $item['material_id'];
            $product_name           = $name =   $item['product_name'];
            $quantity               = $item['quantity'];
            $price                  = $item['price'];
            $totalPrice             = $item['totalPrice'];
            $urlItem                = route('phoneItem',['id'=>$id]);
            $allTotalPriceProduct += $totalPrice;

            $thumb      = ($item['thumb'])? asset('images/product/'.$item['thumb'].'') : asset("images/phonetheme/product.jpg") ;

            $urlDeleteOneCart = route('authsphone/delete');
            $urlUpdateQuantity = route('authsphone/updateQuantity');

            $xhtml .= ' <tr class="cart-item" data-product-id="'.$product_id.'" data-color-id="'.$color_id.'" data-material-id="'.$material_id.'">
                            <td>
                                <a href="'.$urlItem.'"><img
                                        src="'.$thumb.'"
                                        alt="'.$name.'"></a>
                            </td>
                            <td><a href="'.$urlItem.'">'.$name.'</a>
                                <div class="mobile-cart-content row">
                                    <div class="col-xs-3">
                                        <h2 class="td-color text-lowercase">'.$price.' $</h2>
                                    </div>
                                    <div class="col-xs-3">
                                        <h2 class="td-color text-lowercase">
                                            <a href="#" class="icon"><i class="ti-close"></i></a>
                                        </h2>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <h2 class="text-lowercase">'.$price.' $</h2>
                            </td>
                            <td>
                                <div class="qty-box">
                                    <div class="input-group">
                                        <input type="number" name="quantity" value="'.$quantity.'" class="form-control input-number update-quantity" id="quantity-10" min="1"
                                                            data-url-update-quantity="'.$urlUpdateQuantity.'"
                                                            data-product-id="'.$product_id.'"
                                                            data-color-id="'.$color_id.'"
                                                            data-material-id="'.$material_id.'"
                                        >
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="#" class="icon delete-element-cart"
                                            data-url="'.$urlDeleteOneCart.'"
                                            data-product-id="'.$product_id.'"
                                            data-color-id="'.$color_id.'"
                                            data-material-id="'.$material_id.'"
                                ><i class="ti-close"></i></a>
                            </td>
                            <td>
                                <h2 class="td-color text-lowercase totalPriceElement"
                                            data-product-id="'.$product_id.'"
                                            data-color-id="'.$color_id.'"
                                            data-material-id="'.$material_id.'"
                                >'.$totalPrice.' $</h2>
                            </td>
                        </tr>
                        <input type="hidden" name="form[product_id][]" value="'.$id.'" id="input_smart_phone_id_'.$id.'">
                        <input type="hidden" name="form[product_name][]" value="'.$product_name.'" id="input_product_name_'.$product_name.'">
                        <input type="hidden" name="form[color_id][]" value="'.$color_id.'" id="input_color_id_'.$color_id.'">
                        <input type="hidden" name="form[material_id][]" value="'.$material_id.'" id="input_material_id_'.$material_id.'">
                        <input type="hidden" name="form[price][]" value="'.$price.'" id="input_price_'.$id.'">
                        <input type="hidden" name="form[quantity][]" value="'.$quantity.'" id="input_quantity_'.$id.'">
                        <input type="hidden" name="form[thumb][]" value="'.$thumb.'" id="input_thumb_'.$id.'">
                    ';
        }
    }
@endphp

<form action="{{ $buy_url }}" method="POST" name="admin-form" id="admin-form">
    @csrf
    <section class="cart-section section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <table class="table cart-table table-responsive-xs">
                        <thead>
                            <tr class="table-head">
                                <th scope="col">Hình ảnh</th>
                                <th scope="col">Tên smart phone</th>
                                <th scope="col">Giá</th>
                                <th scope="col">Số Lượng</th>
                                <th scope="col"></th>
                                <th scope="col">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            {!! $xhtml !!}
                        </tbody>

                    </table>
                    <table class="table cart-table table-responsive-md">
                        <tfoot>
                            <tr>
                                <td>Tổng :</td>
                                <td>
                                    <h2 class="text-lowercase totalPrice">{{ $allTotalPriceProduct }} $</h2>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="row cart-buttons">
                <div class="col-6"><a href="{{Route('phoneCategory')}}" class="btn btn-solid">Tiếp tục mua sắm</a></div>
                <div class="col-6"><button type="submit" class="btn btn-solid">Đặt hàng</button></div>
            </div>
        </div>
    </section>
</form>
