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
    		  return redirect('customer/logout');
    	
        }else if(session('user')->type != '3'){ // 3=> user
    		
    		return redirect('customer/logout');
    	
    	}
    	
    	return $next($request);
    }
}
