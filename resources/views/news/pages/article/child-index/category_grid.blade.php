@php
    use App\Helpers\Template as Template;
    use Illuminate\Support\Str;
    $titleButton = ($locale == 'en') ? 'See more' : 'Xem thêm';

@endphp

<div class="posts">
    <div class="col-lg-12">
        <div class="row">
            @foreach ($item['related_article'] as $article)

                <div class="col-lg-6">
                    <div class="post_item post_v_small d-flex flex-column align-items-start justify-content-start">
                        @include('news.partials.article.image',['item'=>$article])
                        @include('news.partials.article.content',['item'=>$article,'lenghtContent'=> 200,'showCategory'=>false])
                    </div>
                </div>

            @endforeach

        </div>
        <div class="row">
            @include('news.block.seeMore',['id'=>$itemCategoryArticle['id'],'name'=>$itemCategoryArticle['name']])
        </div>
    </div>
</div>

