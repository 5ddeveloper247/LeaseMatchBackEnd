<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserAuth
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
        if(!$request->session()->has('user')){
    		
        	$request->session()->flash('error', 'Access Denied');
    		  return redirect('login');
    	
        }else if(session('user')->type != 'user'){
    		
    		return redirect('logout');
    	
    	}
    	
    	return $next($request);
    }
}
