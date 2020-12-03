<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Support\Facades\Auth;

class NotAdminAuthenticated
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
        try
        {
            if (Auth::user()->id != $request->user->id && !$request->user->hasRole('administrator'))
            {
                return $next($request);
            }
            else
            {
                return redirect(route('admin.users.index'))->with('message', '権利ありません！');
            }
        }
        catch (Exception $e)
        {
            return redirect(route('admin.users.index'))->with('message', 'ユーザー見つかれません！');
        }
    }
}
