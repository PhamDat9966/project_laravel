/* dropdown menu */
$(document).ready(function() {
    /* sử dụng từ khóa $(this) trong jQuery, từ khóa này sẽ giới hạn hành động chỉ cho phần tử hiện tại mà bạn đang tương tác.
      Để tránh trong trường hợp có 2 thẻ li cùng có class=dropdown cùng thực hiện tác vụ */
    var isClicked = false; // Biến kiểm tra xem có click vào phần tử nào chưa

    // Sự kiện hover vào phần tử .dropdown
    $('.dropdown').hover(
        function() {
            if (!$(this).hasClass('clicked')) { // Chỉ thêm class 'show' khi chưa click vào phần tử này
                $(this).find('.dropdown-menu').addClass('show');
            }
        },
        function() {
            if (!$(this).hasClass('clicked')) { // Chỉ xóa class 'show' khi chưa click vào phần tử này
                $(this).find('.dropdown-menu').removeClass('show');
            }
        }
    );

    // Sự kiện click vào phần tử .dropdown
    $('.dropdown').click(function() {
        // Kiểm tra trạng thái của từng phần tử riêng lẻ
        if (!$(this).hasClass('clicked')) {
            $(this).find('.dropdown-menu').addClass('show'); // Thêm class 'show' cho phần tử hiện tại
            $(this).addClass('clicked'); // Đánh dấu rằng phần tử này đã được click
        } else {
            $(this).find('.dropdown-menu').removeClass('show'); // Xóa class 'show' cho phần tử hiện tại
            $(this).removeClass('clicked'); // Bỏ đánh dấu phần tử đã được click
        }
    });

    // Sự kiện click ra ngoài menu để reset
    $(document).click(function(e) {
        if (!$(e.target).closest('.dropdown').length) {
            $('.dropdown-menu').removeClass('show'); // Xóa class 'show' cho tất cả các dropdown
            $('.dropdown').removeClass('clicked'); // Đặt lại trạng thái chưa click cho tất cả các dropdown
        }
    });

});

