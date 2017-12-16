<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Session;

class AccessTokenFull
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $user = User::find(Session::get('id_user'));
        if (empty($user->access_token_full)) {
            return redirect()->route('home');
        }
        return $next($request);
    }
}
