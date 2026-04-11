@extends('news.main')               {{-- @extends sẽ load nội dung của template() sau cùng, cụ thể ở đây ta sẽ thực hiện khối lệnh php trước --}}
{{-- @include('news.main') --}}     {{-- @include sẽ load nội dung của template() theo trình tự, cụ thể ở đây ta sẽ thực hiện load template
                                                trước sau đó mới thực hiện khối lệnh php--}}
@section('content')

@php
    use App\Helpers\template as Template;
    $locale         = (isset($locale)) ? $locale : 'vi';

    $router         = route($controllerName.'/postContact',['locale' => $locale]);

    $iframe         = '<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15677.303876297865!2d106.692556!3d10.7863269!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f2f20ed1c49%3A0x5781806fe59379f4!2zQ8O0bmcgVHkgQ-G7lSBQaOG6p24gTOG6rXAgVHLDrG5oIFplbmQgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1723095395358!5m2!1svi!2s" width="600" height="650" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
    if(isset($itemGooglemap) && !empty($itemGooglemap)){
        $iframe = $itemGooglemap['googlemap'];
    }
    $iframe         = preg_replace('/height="\d+"/', 'height="520"', $iframe);
    $xhtmlbranch    = Template::showBranchGoogleMapSelect($controllerName, $branch, 'select_change_is_googlemap_filter', $itemGooglemap,$locale);

    $foreword       = '<h3>Gửi tin nhắn cho chúng tôi</h3>
                        <p>Vui lòng để lại thông tin với chúng tôi. Chúng tôi sẽ liên hệ đến Quý Khách trong thời gian sớm nhất.</p>';
    $fullName       = 'Họ tên:';
    $phoneNumber    = 'Số điện thoại:';
    $message        = 'Lời nhắn:';
    $sendMessage    = 'Gửi lời nhắn:';
    $branch         = 'Chi nhánh: ';

    if($locale == 'en'){
        $foreword       = '<h3>Send us a message</h3>
                            <p>Please leave your information with us. We will contact you as soon as possible.</p>';
        $fullName       = 'FullName:';
        $phoneNumber    = 'Phone number:';
        $message        = 'Message:';
        $sendMessage    = 'Send message:';

        $branch         = 'Branch: ';
    }
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
                        </div>
                        <div class="col-lg-12 mb-12">
                            <div class="row">
                                <form method="POST" action="{{$router}}" accept-charset="UTF-8" enctype="multipart/form-data" class="contact-form row" id="contact-form">
                                    @csrf
                                    <div class="col-lg-6 mb-6">
                                       {!! $iframe !!}
                                       <div class="input-group">
                                            <label for="branch">{!! $branch !!}</label>
                                            {!! $xhtmlbranch !!}
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-6">
                                        <div class="input-group mb-3 ml-3">
                                            {!!$foreword!!}
                                        </div>
                                        <div class="mb-3 ml-3">
                                            @include('news.templates.error')
                                        </div>
                                        <div class="input-group ml-3">
                                            <label for="fullname">{!! $fullName !!}</label>
                                        </div>
                                        <div class="input-group mb-3 ml-3">
                                            <input type="text" name="name" class="form-control">
                                        </div>
                                        <div class="input-group ml-3">
                                            <label for="email">Email:</label>
                                        </div>
                                        <div class="input-group mb-3 ml-3">
                                            <input type="text" name="email" class="form-control">
                                        </div>
                                        <div class="input-group ml-3">
                                            <label for="phone">{!! $phoneNumber !!}</label>
                                        </div>
                                        <div class="input-group mb-3 ml-3">
                                            <input type="text" name="phone" class="form-control">
                                        </div>
                                        <div class="input-group ml-3">
                                            <label for="message">{!! $message !!}</label>
                                        </div>
                                        <div class="input-group mb-3 ml-3">
                                            <textarea class="form-control" name="message" rows="3"></textarea>
                                        </div>
                                        <div class="input-group mb-3 ml-3">
                                            <button type="submit"  class="btn btn-primary">{!! $sendMessage !!}</button>
                                        </div>
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

