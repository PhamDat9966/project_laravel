@php

@endphp
@foreach ($itemsCategoryPage as $key=>$item)
    @if ($item['display'] == 'list')
        @include('news.pages.home.child-index.category_list',['item'=>$item,'lenghtContent'=> 500])
    @elseif ($item['display'] == 'grid')
        @include('news.pages.home.child-index.category_grid',['item'=>$item,'lenghtContent'=> 500])
    @endif
@endforeach

