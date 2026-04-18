@php

    use Illuminate\Support\Str;

    $name           = Str::slug($name);
    $urlSeeMore     = route('categoryArticle/getAllArticles',['category_id'=>$id,'category_name'=>$name,'locale' => $locale]);

@endphp
<!-- Extra -->
<!-- Kiểm tra xem trình duyệt đã ở route seeMore chưa, nếu đang ở đó thì ẩn button see More đi -->
@if(!Route::is('categoryArticle/getAllArticles',['category_id'=>$id,'category_name'=>$name,'locale' => $locale]))
    <div class="home_button mx-auto text-center"><a href="{{$urlSeeMore}}">Xem thêm</a></div>
@endif
