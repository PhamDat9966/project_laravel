$(document).ready(function() {
    // test
	// var ojbectURL	= window.location;
    // console.log(ojbectURL);
	// var searchParams = new URLSearchParams(window.location.search);
	// var paramsString	 = (searchParams.get('search_value').replace(/\s+/g,'+'));
	// console.log(paramsString);
    // end test

	let $btnSearchRss        = $("button#btn-search-rss");
	let $btnClearSearch	     = $("button#btn-clear-search-rss");

	let $inputSearchValue           = $("input[name  = search_value_rss]");
    let $selectChangeGoogleMap      = $("select[name =  select_change_is_googlemap_filter]");

    $btnSearchRss.click(function(){

        var pathname = window.location.pathname; //path hien tai không bao gồm param, tức là chỉ lấy đến hết dấu hỏi
        var search_value    = $inputSearchValue.val();
        let link            = 'page=1';

        window.location.href    = pathname + '?' + link + '&' + 'search_value_rss=' + search_value.replace(/\s+/g, '+').toLowerCase();

    });

	// $btnClearSearch.click(function() {
	// 	var pathname	= window.location.pathname;
	// 	let searchParams= new URLSearchParams(window.location.search);

	// 	params 			= ['page', 'filter_status', 'select_filter'];

	// 	let link		= "";
	// 	$.each( params, function( key, value ) {
	// 		if (searchParams.has(value) ) {
	// 			link += value + "=" + searchParams.get(value) + "&"
	// 		}
	// 	});

	// 	window.location.href = pathname + "?" + link.slice(0,-1);
	// });
	$btnClearSearch.click(function() {
		let $path 	= window.location.pathname;
		let searchParams	= new URLSearchParams(window.location.search);

		let $filter = "filter_status";
		let link	= '';
		if(searchParams.has($filter)){
			link	+= $filter + "=" + searchParams.get($filter) + "&";
		}
		window.location.href	= $path + "?" +link.slice(0,-1);

	});
    console.log($('#box-gold').data('url'));
    //ajax box-gold
    $.ajax({
		url		: $('#box-gold').data('url'),
		type	: 'GET',
		success	: function(data){
            console.log("Get gold data: ",data);
            $('#box-gold').html(data);
		}
	})

    //ajax box-coin
    console.log($('#box-coin').data('url'));
    $.ajax({
        url		: $('#box-coin').data('url'),
        type	: 'GET',
        success	: function(data){
            $('#box-coin').html(data);
        }
    })

    $selectChangeGoogleMap.on('change',function(){
        var select_value  = $(this).val();
        var url           = $(this).attr('data-url');
        //var pathname	= window.location.pathname;

        let searchParams = new URLSearchParams(window.location.search);

        // params 			= ['filter_status','search_field', 'search_value'];
        // let link        = '';

        // $.each( params, function( key, value ) {
		// 	if (searchParams.has(value) ) {
		// 		link += value + "=" + searchParams.get(value) + "&"
		// 	}
		// });
        window.location.href    = url + '?' + 'filter_googlemap=' + select_value;

        // url = url+'?filter_display='+select_value;
        // console.log(url);
    });

});

// Phone liên hệ
// $(document).ready(function() {
//     $('#submitModal').on('click', function() {
//         var input = $('#modal-phone-input').val();
//         // Phải nhập số điện thoại từ 9 đến 12 ký tự và phải nhập số
//         var isValid = /^\d{9,12}$/.test(input);
//         var urlPhoneContact = $('#modal-phone-input').data('url');
//         var locale = $('#modal-phone-input').data('locale');

//         if (!isValid) {
//             // alert('Số điện thoại của bạn không hợp lệ, hãy nhập ký tự số và nhập từ 9 đến 12 số');
//             var titleReturn = "Số điện thoại của bạn không hợp lệ! Vui lòng nhập ký tự số và nhập từ 9 đến 12 số</b>";
//             if(locale == 'en'){
//                 titleReturn = "Your phone number is invalid! Please enter a numeric character and enter between 9 and 12 digits</b>";
//             }
//             $(".modal-body p").html(titleReturn);
//         } else {
//             // Thực hiện gửi dữ liệu nếu input hợp lệ
//             $.ajax({
//                 url: urlPhoneContact,
//                 method: 'GET',
//                 data: {
//                     input: input,
//                     _token: '{{ csrf_token() }}'  // Bao gồm CSRF token nếu cần
//                 },
//                 success: function(response) {
//                     $('#exampleModal').modal('hide');
//                     if(locale == 'en'){
//                         alert('Your phone number has been saved. We will contact you soon!');
//                     }else{
//                         alert('Số điện thoại của bạn đã được lưu. Chúng tôi sẽ liên hệ sau!');
//                     }
//                     console.log(response);
//                 },
//                 error: function(xhr, status, error) {
//                     alert('There was an error sending your data.');
//                 }
//             });
//         }
//     });
// });

$(document).ready(function() {
    $('#submitModal').on('click', function() {
        var phone = $('#modal-phone-input').val();
        // Phải nhập số điện thoại từ 9 đến 12 ký tự và phải nhập số
        var isValid = /^\d{9,12}$/.test(phone);
        var urlPhoneContact = $('#modal-phone-input').data('url');
        var locale = $('#modal-phone-input').data('locale');
        var recaptchaResponse = grecaptcha.getResponse();

        if (!isValid) {
            // alert('Số điện thoại của bạn không hợp lệ, hãy nhập ký tự số và nhập từ 9 đến 12 số');
            var titleReturn = "Số điện thoại của bạn không hợp lệ! Vui lòng nhập ký tự số và nhập từ 9 đến 12 số</b>";
            if(locale == 'en'){
                titleReturn = "Your phone number is invalid! Please enter a numeric character and enter between 9 and 12 digits</b>";
            }
            $(".modal-body p").html(titleReturn);
        } else {
            // Thực hiện gửi dữ liệu nếu input hợp lệ
            $.ajax({
                url: urlPhoneContact,
                method: 'GET',
                data: {
                    phone: phone,
                    'g-recaptcha-response': recaptchaResponse,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#exampleModal').modal('hide');
                    if(locale == 'en'){
                        alert('Your phone number has been saved. We will contact you as soon as possible!');
                    }else{
                        alert('Số điện thoại của bạn đã được lưu. Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhât!');
                    }
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseJSON.message || 'Có lỗi xảy ra.');
                }
            });
        }
    });
});

// localStorage
$(document).ready(function() {

    $('#contact-form').on('submit', function() {
        localStorage.setItem("name",$('#contact-form [name="name"]').val());
        localStorage.setItem("email",$('#contact-form [name="email"]').val());
        localStorage.setItem("phone",$('#contact-form [name="phone"]').val());

    });

    if ($('#contact-form') . length > 0){ // Kiểm tra xem có phần tử nào trên trang với ID là contact-form hay không
        $('#contact-form [name="name"]').val(localStorage.getItem("name"));
        $('#contact-form [name="email"]').val(localStorage.getItem("email"));
        $('#contact-form [name="phone"]').val(localStorage.getItem("phone"));
    }
});

//Button chuyển đổi ngôn ngữ
$(document).ready(function() {
    function switchLang(lang) {
        let currentUrl = window.location.href;
        let origin = window.location.origin;
        let pathname = window.location.pathname;

        // Loại bỏ dấu "/" ở đầu và cuối để dễ xử lý, tách pathname thành 2 phần tử 'en' hoặc 'vi' và hậu tố
        let segments = pathname.replace(/^\/|\/$/g, '').split('/');

        // Xác định lang hiện tại (nếu có)
        let currentLang = ['vi', 'en'].includes(segments[0]) ? segments[0] : null;

        // Nếu có lang hiện tại → thay thế
        if (currentLang) {
            segments[0] = lang;
        } else {
            // Nếu không có lang hiện tại → thêm vào phần tử đầu 'vi' hoặc 'en'...
            segments.unshift(lang);
        }

        let newPath = '/' + segments.join('/'); //segments.join('/') nối các phần tử của mảng thành một chuỗi với dấu '/'
        let newUrl = origin + newPath;

        // Nếu khác URL hiện tại thì chuyển
        if (currentUrl !== newUrl) {
           window.location.href = newUrl;
        }
    }

    $('#btn-vi').click(() => switchLang('vi'));
    $('#btn-en').click(() => switchLang('en'));
});
