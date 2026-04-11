@php
    $relatedTitle = ($locale == 'en') ? 'Related Articles' : 'Bài viết liên quan';
@endphp
@if (count($item['related_article']) > 0)
    <div class="section_title_container d-flex flex-row align-items-start justify-content-start zvn-title-category">
        <div>
            <div class="section_title">{{ $relatedTitle }}</div>
        </div>
        <div class="section_bar"></div>
    </div>

    @if ($item['display'] == 'list')
        @include('news.pages.article.child-index.category_list')
    @elseif ($item['display'] == 'grid')
        @include('news.pages.article.child-index.category_grid')
    @endif
@endif
