@extends('news.main')               {{-- @extends sẽ load nội dung của template() sau cùng, cụ thể ở đây ta sẽ thực hiện khối lệnh php trước --}}
{{-- @include('news.main') --}}     {{-- @include sẽ load nội dung của template() theo trình tự, cụ thể ở đây ta sẽ thực hiện load template
                                                trước sau đó mới thực hiện khối lệnh php--}}
@section('content')
    <!-- Content Container -->
    <div class="section-category">
        @include('news.block.breadcrumb',['item'=>['name'=>$title]])

        <div class="content_container container_category">
           <div class="featured_title">
              <div class="container">
                 <div class="row">
                    <!--main content -->
                    @foreach ($images as $image)
                        <div class="col-lg-4 mb-4">
                            <a href="{{asset('/images/shares/' . $image->getFilename())}}" data-fancybox="gallery">
                                <img style="width:100%" src="{{asset('/images/shares/' . $image->getFilename())}}">
                            </a>
                        </div>
                    @endforeach
                 </div>
              </div>
           </div>
        </div>
     </div>
@endsection

