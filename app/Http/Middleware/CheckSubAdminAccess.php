<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use App\Models\MenuControl;

class CheckSubAdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user->type == '2') {
            // Get the current route name
            $currentRouteName = $request->route()->getName();

            $menu = Menu::where('route', $currentRouteName)->first();

            if (!$menu) {
                // If no menu item is found for the current route, deny access
                return response()->view('admin.noaccess', ['page' => '','error' => 'Access denied. No such page exists.'], 403);
            }
            
            $hasAccess = MenuControl::where('user_id', $user->id)
                                    ->where('menu_id', $menu->id)
                                    ->exists();

            if (!$hasAccess) {
                return response()->view('admin.noaccess', ['page' => '','error' => 'Access denied. You do not have permission to access this page.'], 403);
            }
        }

        return $next($request);
    }
}
