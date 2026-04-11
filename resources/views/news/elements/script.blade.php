<script src="{{asset('news/js/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('news/css/bootstrap-4.1.2/popper.js')}}"></script>
<script src="{{asset('news/css/bootstrap-4.1.2/bootstrap.min.js')}}"></script>
<script src="{{asset('news/js/greensock/TweenMax.min.js')}}"></script>
<script src="{{asset('news/js/greensock/TimelineMax.min.js')}}"></script>
<script src="{{asset('news/js/scrollmagic/ScrollMagic.min.js')}}"></script>
<script src="{{asset('news/js/greensock/animation.gsap.min.js')}}"></script>
<script src="{{asset('news/js/greensock/ScrollToPlugin.min.js')}}"></script>
<script src="{{asset('news/js/OwlCarousel2-2.2.1/owl.carousel.js')}}"></script>
<script src="{{asset('news/js/easing/easing.js')}}"></script>
<script src="{{asset('news/js/parallax-js-master/parallax.min.js')}}"></script>

<!-- Tạo calendar với Bootstrap Datepicker -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- reCAPTCHA checkbox -->
<script src="https://www.google.com/recaptcha/api.js?render=6LeMlT4rAAAAALNAcQzj9Z-cfbq5P-SVxyKWgbTO"></script>
<script>
    function getReCaptchaToken(callback) {
        grecaptcha.ready(function() {
            grecaptcha.execute('6LeMlT4rAAAAALNAcQzj9Z-cfbq5P-SVxyKWgbTO', {action: 'submit'}).then(function(token) {
                callback(token);
            });
        });
    }
</script>

<script src="{{asset('news/js/custom.js')}}"></script>
<script src="{{asset('news/js/my-js.js')}}"></script>

{{-- Chỉ khởi động DailyTask khi controller là Rss --}}
@isset($controllerName)
    @if($controllerName == 'rss')
        <script>
            var dailyTaskUrl = "{{ route('dailyScheduler', ['locale' => app()->getLocale()]) }}";
        </script>
        <script src="{{asset('news/js/rundailytask-js.js')}}"></script>
    @endif
@endisset

{{--Calendar--}}
<script src="{{asset('news/js/timeMeet.js')}}"></script>
<script src="{{asset('news/js/dropdown.js')}}"></script>
