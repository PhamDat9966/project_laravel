@php

    $name   = $item['name'];
    $thumb  = asset('images/article/' . $item['thumb']);

@endphp
<div class="post_image">
    <img src="{{ $thumb }}" alt="{{ $name }}" class="img-fluid w-100">
</div>
