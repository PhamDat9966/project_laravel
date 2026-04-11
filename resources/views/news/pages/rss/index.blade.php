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
                    <div class="col-lg-8">
                        @include('news.pages.rss.child-index.list',['items'=>$items])

                    </div>
                    <div class="col-lg-4">
                        <h3>Giá Vàng</h3>
                        <div id="box-gold" class="d-flex align-items-center justify-content-center" data-url="{{route('rss/get-gold', ['locale' => $locale])}}">
                            <img src="{{ asset('images/loading.gif') }}" alt="">
                        </div>
                        {{-- @include('news.pages.rss.child-index.box-gold',['itemsGold'=>$itemsGold]) --}}
                        <h3>Giá Coin</h3>
                        <div id="box-coin" class="d-flex align-items-center justify-content-center" data-url="{{route('rss/get-coin' , ['locale' => $locale])}}">
                            <img src="{{ asset('images/loading.gif') }}" alt="">
                        </div>
                        {{-- @include('news.pages.rss.child-index.box-coin',['itemsCoin'=>$itemsCoin]) --}}
                    </div>
                 </div>
              </div>
           </div>
        </div>
     </div>

     @if (count($items) > 0)
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
                {{-- @include('news.templates.x_title',['title'=>'Phân trang']) --}}
                @include('news.block.pagination')
        </div>
    </div>
    @endif
@endsection


