<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocaleLanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Lấy ngôn ngữ từ segment đầu tiên của URL
        $locale = $request->segment(1);

        // Các ngôn ngữ được hỗ trợ
        $availableLocales = ['en', 'vi'];

        if (in_array($locale, $availableLocales)) {
            App::setLocale($locale);
            Session::put('locale', $locale);
        } else {
            // Nếu không có locale, mặc định là 'vi'
            App::setLocale('vi');
            Session::put('locale', 'vi');
        }

        return $next($request);
    }
}
