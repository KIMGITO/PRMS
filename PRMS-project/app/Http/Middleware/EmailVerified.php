<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EmailVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
{
    if(in_array($request->route()->getName(), ['verify.otp', 'resend.otp', 'verify.email.form'])) {
        if (Auth::check() && Auth::user()->verified == 1) {
            return redirect('/'.Auth::user()->role);
        }
    }else{
        if (Auth::check() && Auth::user()->verified != 1) {
            return redirect()->route('verify.email.form');
        }
    }

    return $next($request);
}


}
