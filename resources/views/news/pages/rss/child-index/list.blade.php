@php
    use App\Helpers\Template as Template;
    use Illuminate\Support\Str;
    use App\Helpers\Hightlight as Hightlight;

    $searchValueRss    = ($params['search']['value'] != '') ? $params['search']['value'] : '';

    $xhtmlAreaSearch    = sprintf('<div class="input-group">
                                <input type="text" class="form-control" name="search_value_rss" value="%s">
                                <span class="input-group-btn">
                                    <button id="btn-clear-search-rss" type="button" class="btn btn-success"
                                            style="margin-right: 0px">Xóa tìm kiếm</button>
                                    <button id="btn-search-rss" type="button" class="btn btn-primary">Tìm kiếm</button>
                                </span>
                            </div>',$searchValueRss);
@endphp

<div class="posts">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-md-12 mb-4">
                {!!$xhtmlAreaSearch!!}
            </div>
        </div>
        <div class="row">
            @foreach ($items as $item)
                @php
                    $name           = html_entity_decode($item['title']);
                    $name           = preg_replace('/&#\d+;/', '', $name);
                    $name           = str_replace($params['search']['value'], '<span style="color: red;">'.$params['search']['value'].'</span>', $name);

                    $thumb          = $item['thumb'];
                    $link           = $item['link'];
                    $created        = $item['pubDate'];
                    $content        = html_entity_decode(Template::showContent($item['description'], 300));
                    $created_by      = $item['created_by'];
                @endphp
                <div class="col-lg-6">
                    <div class="post_item post_v_small d-flex flex-column align-items-start justify-content-start">

                        {{-- images --}}
                        <div class="post_image">
                            <img src="{{ $thumb }}" alt="{{ $name }}" class="img-fluid w-100">
                        </div>

                        {{-- content --}}
                        <div class="post_content">
                            <div class="post_title"><a
                                    href="{{ $link }}">{!! $name !!}</a></div>
                            <div class="post_info d-flex flex-row align-items-center justify-content-start">
                                <div class="post_author d-flex flex-row align-items-center justify-content-start">
                                    <div class="post_author_name"><a href="#">{{ $created_by }}</a>
                                    </div>
                                </div>
                                <div class="post_date"><a href="#">{{$created}}</a></div>
                            </div>

                                <div class="post_text">
                                    <p>
                                        {{$content}}
                                    </p>
                                </div>
                        </div>
                        {{-- end content --}}
                    </div>
                </div>

            @endforeach

        </div>
        {{-- <div class="row">
            <div class="home_button mx-auto text-center"><a href="the-loai/giao-duc-2.html">Xem
                thêm</a></div>
        </div> --}}
            {{-- <div class="row">
                <div class="card">
                        {!!$pagination!!}
                </div>
            </div> --}}
    </div>
</div>

