<?php

namespace App\Http\Middleware;

use Closure,Session,Log;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class checkPermission
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
        if (!Auth::user()->hasPermissionTo(\Request::route()->getName())) {
            $datas = json_encode([
                'user'=>Auth::user(),
                'error'=>'User Not Have Permission to this route',
                'url'=> \Request::route()->getPrefix(),
                'routeName'=>\Request::route()->getName(),
            ]);
            Log::error($datas);
            Session::flash('warning','User Not Have Permission to this route');

            return redirect(RouteServiceProvider::HOME);
        }
        return $next($request);
    }
}
