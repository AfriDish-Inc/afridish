<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Closure;
use Session;
use App\Cart;

class EnsureCartIsNotEmpty
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
        if (Auth::guest()) {
            if (!Session::has('cart')) {
                return Redirect::to('/');
            }
        } else {
            if (! Cart::where('user_id', '=', Auth::user()->id)->exists()) {
                return Redirect::to('/');
            }
        }
        return $next($request);
    }
}
