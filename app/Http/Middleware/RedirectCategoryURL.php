<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectCategoryURL
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

        $uri = $request->getRequestUri();

        if (preg_match('/^\/cm-(.+)-(\d+)\.html$/', $uri, $matches)) {
            $newUri = '/cm/' . $matches[1] . '-' . $matches[2] . '.html';
            return redirect($newUri, 301); // 301 Permanent Redirect
        }

        return $next($request);
    }
}
