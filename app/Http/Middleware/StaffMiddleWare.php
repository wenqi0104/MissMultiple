<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

class StaffMiddleWare
{
    protected $auth;


    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->type !== 'Staff'){
            if (auth()->user()->type == 'Admin') {
                return redirect('/admin');
            } elseif (auth()->user()->type == 'Student') {
                return redirect('/student');
            }
        }

        return $next($request);

        
    }

}
