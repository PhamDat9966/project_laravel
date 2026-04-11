<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;

class LocaleController extends Controller
{
    protected $locale;
    public function __construct()
    {
        /*
            Middleware (LocaleLanguageMiddleware) luôn chạy trước khi controller xử lý request, nhưng hàm __construct() đã hoàn thành xong trước khi
            LocaleLanguageMiddleware chạy xong nên nếu gọi App::getLocale thì nó sẽ trả về giá trị không dúng.
            Giải pháp: Gọi middleware ngay  trong hàm nội bộ _construct. Để lấy $locale = AppL:getLocale một cách chính xác.

                1. Khi Laravel khởi tạo controller, Middleware nội bộ ($this->middleware()) sẽ chạy sau LocaleLanguageMiddleware,
                nghĩa là App::getLocale() trong  LocaleLanguageMiddleware lúc này đã được cập nhật (xem LocaleLanguageMiddleware).
                2. Biến $this->locale sẽ có giá trị chính xác sau Middleware và có thể dùng trong tất cả phương thức (index(), show(), v.v.).
                3. Không cần gọi App::getLocale() trong từng phương thức, tránh code lặp lại.
        */
        $this->middleware(function ($request, $next) {
            $this->locale = App::getLocale();
            View::share('locale', $this->locale);
            return $next($request);
        });
    }

    public function getLocale()
    {
        return $this->locale;
    }
}
