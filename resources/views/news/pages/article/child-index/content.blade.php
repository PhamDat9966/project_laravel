@php
    use App\Helpers\Template as Template;
    use Illuminate\Support\Str;
    use App\Helpers\URL;
    if($itemArticle['translations']){
        foreach($itemArticle['translations'] as $key=>$translation){
            $name               = $translation['name'];
            $showCategory       = (isset($showCategory)) ? $showCategory : 'false';
            $categoryName       = (isset($itemArticle['category_name'])) ? $itemArticle['category_name']:"";

            $linkCategory       = URL::linkCategoryArticle($itemArticle['category_id'],$itemArticle['category_name']);
            $linkArticle        = URL::linkArticle($itemArticle['id'],$itemArticle['name']);
            $created            = Template::showDataFrontEnd($itemArticle['created']);
            if($lenghtContent == 'full'){
                $content            = $translation['content'];
            }else{
                $content            = Template::showContent($translation['content'], $lenghtContent);
            }
            $created_by         = 'Lưu Trường Hải Lân';
            $classPost          = Str::slug($categoryName);
        }
    } else{
            //Nếu bản dịch không tồn tại thì sử dụng mặc định
            $name               = $itemArticle['name'];
            $showCategory       = (isset($showCategory)) ? $showCategory : 'false';
            $categoryName       = (isset($itemArticle['category_name'])) ? $itemArticle['category_name']:"";

            $linkCategory       = URL::linkCategoryArticle($itemArticle['category_id'],$itemArticle['category_name']);
            $linkArticle        = "/$locale/". URL::linkArticle($itemArticle['id'],$itemArticle['name']);
            $created            = Template::showDataFrontEnd($itemArticle['created']);
            if($lenghtContent == 'full'){
                $content            = $itemArticle['content'];
            }else{
                $content            = Template::showContent($itemArticle['content'], $lenghtContent);
            }
            $created_by         = 'Lưu Trường Hải Lân';
            $classPost          = Str::slug($categoryName);
    }
@endphp

<div class="post_content">
    <div class="post_category cat_technology {{$classPost}}">
        <a href="{{$linkCategory}}">{{$categoryName}}</a>
    </div>
    <div class="post_title"><a href="{{$linkArticle}}">{{$name}}</a></div>
    <div class="post_info d-flex flex-row align-items-center justify-content-start">
        <div class="post_author d-flex flex-row align-items-center justify-content-start">
            <div class="post_author_name"><a href="{{$linkArticle}}">{{$created_by}}</a></div>
        </div>
        <div class="post_date"><a href="{{$linkArticle}}">{{$created}}</a>
        </div>
    </div>
    @if ($lenghtContent > 0)
        <div class="post_text">
            <p>{!!$content!!}</p>
        </div>
    @elseif ($lenghtContent == 'full')
        <div class="post_text">
            <p>{!!$content!!}</p>
        </div>
    @endif

</div>
