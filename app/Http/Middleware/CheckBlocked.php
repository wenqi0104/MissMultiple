<?php

namespace App\Http\Middleware;

use Closure;

class CheckBlocked
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

        if (auth()->check() && auth()->user()->status == 'Blocked') 
        {
            auth()->logout();     
            $message = 'Your account has been blocked. ';        
            return redirect()->route('login')->withMessage($message);      
            }
        return $next($request);
    }
}
