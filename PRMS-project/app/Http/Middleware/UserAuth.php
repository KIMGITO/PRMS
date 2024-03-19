<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if(User::count() > 0){
        //     return $next($request);
        // }else{
        //     return redirect()->route('first.admin');
        // }
    
        if($request->route()->getName() == 'index'){
            if(User::count() == 0){
              return redirect()->route('first.admin');
            }
            if(Auth::check()){
                return redirect('/'.auth()->user()->role)->with('error',"You are already logged in as ".auth()->user()->first_name);
            }
            
           
        }elseif($request->route()->getName() == 'logout' && !Auth::check()){
            abort(404,'Not found');
        }elseif($request->route()->getName() != 'index.auth' && !Auth::check()){
            return redirect('/')->with('error','You need to log in first to continue');
        }

        return $next($request);
        

    
    }
}
