@php
    use App\Helpers\Template as Template;
    use Illuminate\Support\Str;
    use App\Helpers\URL;

    $showCategory           = (isset($showCategory)) ? $showCategory : 'false';
    $categoryName           = $item['category_name']  = (isset($item['category_name'])) ? $item['category_name']:"";
    $item['category_id']    = (isset($item['category_id'])) ? $item['category_id']:"";

    $linkCategory       = URL::linkCategoryArticle($item['category_id'],$item['category_name']);
    $created_by         = 'Lưu Trường Hải Lân';
    $classPost          = Str::slug($categoryName);
    $created            = Template::showDataFrontEnd($item['created']);
    $name               = 'Nội dung chưa có bản ngôn ngữ "' .$locale.'"';
    if($locale != 'vi'){
        $name               = 'Content is not available in "' .$locale. '" language yet.';
    }
    $thumb              = asset('images/article/' . $item['thumb']);
    $linkArticle        = '';
    $content            = 'Content has no translation yet';

    if(!empty($item['translations'])){

        foreach($item['translations'] as $translation){

            if($locale == $translation['locale']){
                $name               = $translation['name'];
                if(!empty($item['slug'])){
                    $linkArticle    = "/$locale/". $translation['slug'] . '.php';
                }else{
                    $linkArticle    = URL::linkArticle($translation['id'],$translation['name']);
                }
                $content            = html_entity_decode(Template::showContent($translation['content'], $lenghtContent));
                break;
            }
        }
    }

@endphp
<div class="post_content">
    @if($showCategory == true)
        <div class="post_category cat_technology {{$classPost}}">
            <a href="{{ $linkCategory }}">{{ $categoryName }}</a>
        </div>
    @endif
    <div class="post_title"><a
            href="{{ $linkArticle }}">{{ $name }}</a></div>
    <div class="post_info d-flex flex-row align-items-center justify-content-start">
        <div class="post_author d-flex flex-row align-items-center justify-content-start">
            <div class="post_author_name"><a href="#">{{ $created_by }}</a>
            </div>
        </div>
        <div class="post_date"><a href="#">{{$created}}</a></div>
    </div>

    @if ($lenghtContent > 0)
        <div class="post_text">
            <p>
                {{$content}}
            </p>
        </div>
    @endif
</div>
