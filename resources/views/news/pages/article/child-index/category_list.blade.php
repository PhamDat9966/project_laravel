@php
    use App\Helpers\Template as Template;
    use Illuminate\Support\Str;
    $titleButton = ($locale == 'en') ? 'See more' : 'Xem thêm';
@endphp
<div class="posts">
    @foreach ($item['related_article'] as $article)
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

<div class="row">
    @include('news.block.seeMore',['id'=>$itemCategoryArticle['id'],'name'=>$itemCategoryArticle['name']])
</div>
