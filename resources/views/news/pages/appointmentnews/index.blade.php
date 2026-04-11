@extends('news.main')
@section('content')

@php
    use App\Helpers\template as Template;

    $title                  = 'Vui lòng để lại thông tin, nhu cầu của quý khách. Chúng tôi sẽ liên hệ đến Quý Khách trong thời gian sớm nhất';
    $name                   = 'Họ và tên';
    $timeMeetPlaceholder    = 'Chọn ngày và giờ gặp mặt';
    $branchTitle                 = 'Chi nhánh';
    $sexTitle                    = 'Giới tính';
    $serviceTitle                = 'Dịch vụ';
    $phone                       = 'Số điện thoại';
    $note                        = 'Ghi chú (nếu có) ...';
    $appointment                 = 'Đặt lịch hẹn';

    if($locale == 'en'){
        $title                  = 'Please leave your information and needs. We will contact you as soon as possible.';
        $name                   = 'Full name';
        $timeMeetPlaceholder    = 'Select a date and time to meet';
        $branchTitle            = 'Branch';
        $sexTitle               = 'Gender';
        $serviceTitle           = 'Service';
        $phone                  = 'Phone number';
        $note                   = 'Notes (if any) ...';
        $appointment            = 'Make an appointment';
    }

    $router         = route($controllerName.'/save',['locale' => $locale]);
    $timeMeet       = '<input type="text" id="datetime-picker" name="timeMeet" class="form-control" placeholder="'.$timeMeetPlaceholder.'">';
    $xhtmlbranch    = Template::showItemFilterSimpleFrontendWithArray($branch, 'branch' ,$branchTitle);
    $xhtmlSex       = Template::showItemFilterSimpleFrontend('gender', $sexTitle);
    $xhtmlService   = Template::showItemFilterSimpleFrontend('service', $serviceTitle);

@endphp
    <!-- Content Container -->
    <div class="section-category">
        @include('news.block.breadcrumb',['item'=>['name'=>$title]])
        <div class="content_container container_appointment">
           <div class="featured_title">
               <div class="container">
                    <div class="row">
                        <div class="col-lg-12 mb-12">
                            <!--main content -->
                            <div class="title-box mb-4">
                                @include('news.templates.zvn_notily')
                            </div>
                            <div class="title-box mb-4">
                                <p>{!!$title!!}</p>
                            </div>
                        </div>
                        <div class="col-lg-12 mb-12">
                                @include('news.templates.error')
                        </div>
                        <div class="col-lg-12 mb-12">
                            <div class="row">
                                <form method="GET" action="{{$router}}" accept-charset="UTF-8" enctype="multipart/form-data" class="contact-form row" id="main-form"><input name="_token" type="hidden" value="XGzMbjHQ5DGTCLNz6ptF0lusIBlvXcR0GJd2wRct">
                                    <div class="col-lg-12 mb-12">
                                        <div class="row">
                                            <div class="col-lg-6 mb-6">
                                                <div class="input-group mb-3">
                                                    <input type="text" name="fullname" placeholder="{{$name}}" class="form-control">
                                                </div>
                                                <div class="input-group mb-3">
                                                    {!! $timeMeet !!}
                                                </div>
                                                <div class="input-group mb-3">
                                                    {!!$xhtmlService !!}
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-6">
                                                <div class="input-group mb-3">
                                                    <input type="text" name="phone" placeholder="{{$phone}}" class="form-control">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <input type="text" name="email" placeholder="Email" class="form-control">
                                                </div>
                                                <div class="input-group mb-3">
                                                    {!! $xhtmlSex !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 mb-12">
                                        <div class="input-group mb-3">
                                            {!! $xhtmlbranch !!}
                                        </div>
                                        <div class="input-group mb-3">
                                            <textarea class="form-control" name="note" placeholder="{{$note}}"  rows="5"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <button type="submit"  class="btn btn-primary">{{$appointment}}</button>
                                    </div>

                                </form>
                                <!--/main content -->
                            </div>
                        </div>

                 </div>
              </div>
           </div>
        </div>
     </div>
@endsection

