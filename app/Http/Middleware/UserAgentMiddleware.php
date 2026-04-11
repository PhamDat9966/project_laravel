<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class UserAgentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userAgent = $request->header('User-Agent');

        // Lưu thông tin vào cơ sở dữ liệu hoặc thực hiện các thao tác khác theo nhu cầu của bạn
        DB::table('user_agents')->insert(['agent' => $userAgent]);

        return $next($request);
    }
}
