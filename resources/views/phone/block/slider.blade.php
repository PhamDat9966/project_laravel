@php
    use App\Helpers\Template as Template;

    $xhtmlSliders = '';
    if($sliders){
        foreach($sliders as $slider){
            $image = Template::showSliderSmartPhone('sliderPhone',$slider['thumb'],$slider['name']);
            $xhtmlSliders .= '<div>
                                <a href="" class="home text-center">
                                    '.$image.'
                                </a>
                             </div>';
        }
    }

@endphp
<section class="p-0 my-home-slider">
    <div class="slide-1 home-slider">
        {!! $xhtmlSliders !!}
    </div>
</section>
