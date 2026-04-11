@php
    use App\Helpers\Template as Template;
    use Illuminate\Support\Str;
    //dd($item);
@endphp
<div class="posts">
    @foreach ($item->article as $article)
        <div class="post_item post_h_large">
            <div class="row">
                <div class="col-lg-5">
                    @include('news.partials.article.image',['item'=>$article])
                </div>
                <div class="col-lg-7">
                    @include('news.partials.article.content',['item'=>$article,'lenghtContent'=> 200, 'showCategory'=>false])
                </div>
            </div>
        </div>
    @endforeach
</div>

@if ($item['article_child'] != null)
<div class="posts">
    <div class="mx-auto my-4" style="width: 50%;">
        <h3><strong>Những Bài Viết Có Liên Quan</strong></h3>
    </div>
    @foreach ($item->article_child as $article_child)
        <div class="post_item post_h_large">
            <div class="row">
                <div class="col-lg-5">
                    @include('news.partials.article.image',['item'=>$article_child])
                </div>
                <div class="col-lg-7">
                    @include('news.partials.article.content',['item'=>$article_child,'lenghtContent'=> 200, 'showCategory'=>false])
                </div>
            </div>
        </div>
    @endforeach
</div>
@endif


<div class="row">
    <div class="home_button mx-auto text-center"><a href="the-loai/the-thao-1.html">Xem
        thêm</a></div>
</div>
