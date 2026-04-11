@extends('news.main')               {{-- @extends sẽ load nội dung của template() sau cùng, cụ thể ở đây ta sẽ thực hiện khối lệnh php trước --}}
{{-- @include('news.main') --}}     {{-- @include sẽ load nội dung của template() theo trình tự, cụ thể ở đây ta sẽ thực hiện load template
                                                trước sau đó mới thực hiện khối lệnh php--}}
@section('content')
    <!-- Content Container -->
    <div class="section-category">
        <div class="content_container container_category">
           <div class="featured_title">
              <div class="container">
                 <div class="row">

                    <!-- Main Content -->
                    <div class="col-lg-9">
                        <div class="main-content">
                            @if ($locale == 'vi')
                                <h3>Bạn Không Có Quyền Truy Cập Vào Chức Năng Này!</h3>
                            @else
                                <h3>You Do Not Have Access To This Feature!</h3>
                            @endif
                        </div>

                    </div>
                    <!-- Sidebar -->
                    <div class="col-lg-3">
                        <div class="sidebar">
                            <!-- Latest Posts -->
                            @include('news.block.lasted-posts',['items'=>$itemsLatest])
                            <!-- Advertisement -->
                            @include('news.block.advertisement',['itemsAdvertisement'=>[]])
                            <!-- Most Viewed -->
                            @include('news.block.most-viewed',['itemsMostViewed'=>[]])
                            <!-- Tags -->
                            @include('news.block.tags',['itemsTags'=>[]])
                        </div>
                    </div>
                 </div>
              </div>
           </div>
        </div>
     </div>
@endsection

