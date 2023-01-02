<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
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
        if(Auth::guest()) return redirect('/login');

        if(request()->routeIs('admin')) return $next($request);

        $menu = config('menu');
        foreach ($menu as $item) {
            $permission = isset($item['permission']) ? in_array(Auth::user()->role, $item['permission']) : true;
            if(isset($item['route']) && strpos('/'.$request->path(), $item['route']) === 0 && $permission) {
               return $next($request);
            }
            if(isset($item['items'])) {
                foreach ($item['items'] as $subItem) {
                    $permission = isset($subItem['permission']) ? in_array(Auth::user()->role, $subItem['permission']) : true;
                    if(isset($subItem['route']) && strpos('/'.$request->path(), $subItem['route']) === 0 && $permission) {
                        return $next($request);
                    }
                }
            }
        }
        return redirect('/');
    }
}
