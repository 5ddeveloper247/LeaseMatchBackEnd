<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use App\Models\MenuControl;

class AdminAuth
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
        $currentRouteName = $request->route()->getName();
        
    	if(!$request->session()->has('user')){
    		 
    		$request->session()->flash('error', 'Access Denied');
    		return redirect('admin');
    		 
    	}
    	else if(Auth::user()->type == '1' || Auth::user()->type == '2'){ // 1=>superadmin, 2=>subadmin
    		 
            return $next($request);
        }else{
            $request->session()->flash('error', 'Access Denied');
    		return redirect('admin/login');
        }
        
    }
}
