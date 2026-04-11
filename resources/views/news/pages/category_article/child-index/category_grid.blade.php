@php
    use App\Helpers\Template as Template;
    use Illuminate\Support\Str;

@endphp

<div class="posts">
    <div class="col-lg-12">
        <div class="row">
            @foreach ($item['article'] as $article)

                <div class="col-lg-6">
                    <div class="post_item post_v_small d-flex flex-column align-items-start justify-content-start">
                        @include('news.partials.article.image',['item'=>$article])
                        @include('news.partials.article.content',['item'=>$article,'lenghtContent'=> 200,'showCategory'=>false])
                    </div>
                </div>

            @endforeach

        </div>
        <div class="row">
            <div class="home_button mx-auto text-center"><a href="the-loai/giao-duc-2.html">Xem
                thêm</a></div>
        </div>
    </div>
</div>

@if ($item['article_child'] != null)
<div class="posts">
    <div class="mx-auto my-4" style="width: 50%;">
        <h3><strong>Những Bài Viết Có Liên Quan</strong></h3>
    </div>
    <div class="col-lg-12">
        <div class="row">
            @foreach ($item->article_child as $article_child)

                <div class="col-lg-6">
                    <div class="post_item post_v_small d-flex flex-column align-items-start justify-content-start">
                        @include('news.partials.article.image',['item'=>$article_child])
                        @include('news.partials.article.content',['item'=>$article_child,'lenghtContent'=> 200,'showCategory'=>false])
                    </div>
                </div>

            @endforeach

        </div>
        <div class="row">
            <div class="home_button mx-auto text-center"><a href="the-loai/giao-duc-2.html">Xem
                thêm</a></div>
        </div>
    </div>
</div>

@endif
