@php
    use App\Helpers\Template as Template;
    use Illuminate\Support\Str;
    use App\Helpers\URL;

    $titleRecent = ($locale == 'en') ? "Recent Posts" :"Bài viết gần đây";

@endphp
<div class="sidebar_latest">
    <div class="sidebar_title">{{ $titleRecent }}</div>
    <div class="latest_posts">
        @foreach ($items as $item)
            @php
                $name               = $item['name'];
                $thumb              = asset('images/article/' . $item['thumb']);
                $categoryName       = $item['category_name'];
                $linkCategory       = URL::linkCategoryArticle($item['category_id'],$item['category_name']);
                $linkArticle        = '';
                if(!empty($item['slug'])){
                    $linkArticle    = "/$locale/". $item['slug'].'.php';
                }else{
                    $linkArticle    = URL::linkArticle($item['id'],$item['name']);
                }
                $created            = Template::showDataFrontEnd($item['created']);
                $created_by         = 'Lưu Trường Hải Lân';
                $classPost          = Str::slug($categoryName);
                $thumb              = asset('images/article/' . $item['thumb']);

                if($locale == 'en'){
                    $name = 'Content is not available in "en" language yet.';
                    if($item['translations']){
                        foreach($item['translations'] as $key=>$translation){
                            $name               = $translation['name'];
                            $linkArticle        = "/$locale/". $translation['slug'] .'.php';
                        }
                    }
                }
            @endphp
            <!-- Latest Post -->
            <div class="latest_post d-flex flex-row align-items-start justify-content-start">
                <div>
                    <div class="latest_post_image">
                        <img src="{{$thumb}}" alt="{{$name}}">
                    </div>
                </div>
                <div class="latest_post_content">
                    <div class="post_category_small cat_video"><a href="{{$linkCategory}}">{{$categoryName}}</a></div>
                    <div class="latest_post_title">
                        <a href="{{$linkArticle}}">{{$name}}
                        </a>
                    </div>
                    <div class="latest_post_date">{{$created}}</div>
                </div>
            </div>
        @endforeach

    </div>
</div>
