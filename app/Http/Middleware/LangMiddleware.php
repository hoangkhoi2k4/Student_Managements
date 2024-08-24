<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LangMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd(Session::get('lang'));
        if(Session::has('lang')) {
            App::setLocale(Session::get('lang'));
            // dd(App::getLocale());
        }else{
            App::setLocale('vi');
        }
        // dd(App::getLocale());
        return $next($request);
    }
}
