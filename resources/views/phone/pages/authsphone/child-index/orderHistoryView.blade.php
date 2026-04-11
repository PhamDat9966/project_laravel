@php
    use App\Helpers\Template as Template;

    $xhtmlInvoice = '';
    if($userInvoice){
        foreach($userInvoice as $key=>$invoice){

            $id              = $invoice['id'];
            $invoiceCode     = $invoice['code'];
            $date            = date("d/m/Y H:i:s", strtotime($invoice['created']));

            $xhtmlInvoice   .= '<div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0"><button style="text-transform: none;" class="btn btn-link collapsed"
                                                type="button" data-toggle="collapse" data-target="#'.$id.'">Mã đơn hàng:
                                                '.$invoiceCode.'</button>&nbsp;&nbsp;Thời gian: '.$date.'</h5>
                                    </div>
                                    <div id="'.$id.'" class="collapse" data-parent="#accordionExample" style="">
                                        <div class="card-body table-responsive">
                                            <table class="table btn-table">
                                                <thead>
                                                    <tr>
                                                        <td>Hình ảnh</td>
                                                        <td>Tên Smart Phone</td>
                                                        <td>Giá</td>
                                                        <td>Số lượng</td>
                                                        <td>Thành tiền</td>
                                                    </tr>
                                                </thead>

                                                <tbody>';
            $allTotalPrice       = 0;

            foreach($invoice['invoice_product'] as $invoiceProduct){
                $name            = $invoiceProduct['product_name'] . ' - Màu:' . $invoiceProduct['color_name'] . ' - Dung lượng:' .$invoiceProduct['material_name'];
                $alt             = $invoiceProduct['product_name'];
                $thumbName       = $invoiceProduct['thumb'];
                $image           = Template::showProductThumbInOrderHistory('product',$thumbName,$alt);

                $price           = $invoiceProduct['price'];
                $quantity        = $invoiceProduct['quantity'];
                $totalPrice      = $invoiceProduct['total_price'];
                $allTotalPrice  += $totalPrice;
                $xhtmlInvoice   .=                  '<tr>
                                                        <td><a href="#">
                                                            '.$image.'
                                                            </a>
                                                        </td>
                                                        <td style="min-width: 200px">'.$name.'</td>
                                                        <td style="min-width: 100px">'.$price.' $</td>
                                                        <td>'.$quantity.'</td>
                                                        <td style="min-width: 150px">'.$totalPrice.' đ</td>
                                                    </tr>';
            }

            $xhtmlInvoice  .= '                 </tbody>
                                                <tfoot>
                                                    <tr class="my-text-primary font-weight-bold">
                                                        <td colspan="4" class="text-right">Tổng: </td>
                                                        <td>'.$allTotalPrice.' $</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>';
        }
    }else{
        $xhtmlInvoice = '<div class="card-header">
                            <h5 class="mb-0">
                                Tài bạn của bạn chưa có đơn hàng nào.
                            </h5>
                        </div>';
    }
@endphp
<section class="faq-section section-b-space">
    <div class="container">
        <div class="row">

            @include('phone.pages.authsphone.child-index.accountSidebar',['active'=>'authsphone/orderHistory'])

            <div class="col-lg-9">
                <div class="accordion theme-accordion" id="accordionExample">
                    <div class="accordion theme-accordion" id="accordionExample">
                        {!! $xhtmlInvoice !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
