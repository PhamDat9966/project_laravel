
{{-- <!--SweetAlert2  -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

<script src="{{asset('news/js/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('news/css/bootstrap-4.1.2/popper.min.js')}}"></script>
<script src="{{asset('news/css/bootstrap-4.1.2/bootstrap.js')}}"></script>
<script src="{{asset('news/js/greensock/TweenMax.min.js')}}"></script>
<script src="{{asset('news/js/greensock/TimelineMax.min.js')}}"></script>
<script src="{{asset('news/js/scrollmagic/ScrollMagic.min.js')}}"></script>
<script src="{{asset('news/js/greensock/animation.gsap.min.js')}}"></script>
<script src="{{asset('news/js/greensock/ScrollToPlugin.min.js')}}"></script>
<script src="{{asset('news/js/OwlCarousel2-2.2.1/owl.carousel.js')}}"></script>
<script src="{{asset('news/js/easing/easing.js')}}"></script>
<script src="{{asset('news/js/parallax-js-master/parallax.min.js')}}"></script>
<script src="{{asset('news/js/custom.js')}}"></script>
<script src="{{asset('news/js/my-js.js')}}"></script>
{{-- Chỉ khởi động DailyTask khi controller là Rss --}}
@if($controllerName == 'rss')
    <script src="{{asset('news/js/rundailytask-js.js')}}"></script>
@endif

{{-- <!-- Popup button -->
<script>
$(document).ready(function() {
    $('#openPopupButton').on('click', function() {
        Swal.fire({
            title: 'Liên hệ với chúng tôi',
            html: '<input type="text" id="swal-input1" class="swal2-input" placeholder="Nhập số điện thoại">',
            // showCancelButton: true,
            confirmButtonText: 'Yêu cầu gọi lại',
            //preConfirm thu thập giá trị từ input và trả về nó dưới dạng đối tượng.
            preConfirm: () => {
                // Trả về giá trị của input
                return $('#swal-input1').val();

                // return new Promise((resolve) => {
                //     resolve({
                //         input1: $('#swal-input1').val(),
                //     })
                // })
            }
        }).then((result) => {
            // `then` tiếp tục xử lý kết quả từ preConfirm. Nếu kết quả là isConfirmed,
            // nghĩa là người dùng đã nhấn nút Submit, thì AJAX sẽ được gửi đi với giá trị của input.

            if (result.isConfirmed) {
                var inputValue = result.value.input1;

                // Send data to controller using AJAX
                $.ajax({
                    url: '/your-controller-url',  // Replace with your controller URL
                    method: 'POST',
                    data: {
                        input: inputValue,
                        _token: '{{ csrf_token() }}'  // Include CSRF token if needed
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Your data has been sent!',
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'There was an error sending your data.',
                        });
                    }
                });
            }
        });
    });
});
</script> --}}
