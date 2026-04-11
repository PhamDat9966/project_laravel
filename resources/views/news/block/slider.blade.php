@if (count($itemsSlider) > 0)
    <!-- Home -->
    <div class="home">
        <!-- Home Slider -->
        <div class="home_slider_container">
            <div class="owl-carousel owl-theme home_slider">
                @foreach ($itemsSlider as $value)
                    @php
                        $id             = $value['id'];
                        $name           = $value['name'];
                        $description    = $value['description'];
                        $link           = $value['link'];
                        //$thumb             = asset("images/slider/" . $value['thumb'];);
                        $thumb          = url("/images/slider") . '/' . $value['thumb'];
                        $seeDetails     = ($locale == 'en') ? 'See details' : 'Xem chi tiết';
                    @endphp
                    <div class="owl-item home_slider_item">
                        <div class="background_image"
                            style="background-image:url({!!$thumb!!})"></div>
                        <div class="home_slider_content text-center">
                            <div class="home_slider_content_inner" data-animation-in="fadeIn"
                                data-animation-out="animate-out fadeOut">
                                <div class="home_title">{{ $name }}</div>
                                <div class="home_text">
                                    {{ $description }}
                                </div>
                                <div class="home_button trans_200"><a href="{!!$link!!}">{{$seeDetails}}</a></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @if (count($itemsSlider) !== 1)
                <!-- Home Slider Navigation -->
                <div class="home_slider_nav home_slider_prev trans_200"><i class="fa fa-angle-left trans_200"
                    aria-hidden="true"></i></div>
                <div class="home_slider_nav home_slider_next trans_200"><i class="fa fa-angle-right trans_200"
                    aria-hidden="true"></i></div>
            @endif
        </div>
    </div>
@endif
