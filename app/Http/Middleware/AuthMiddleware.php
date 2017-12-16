<?php

namespace App\Http\Middleware;

use Auth;

use Closure;


class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (!$request->session()->has('user_name')) {
            return redirect()->route('login');
        }
        return $next($request);
    }
}
