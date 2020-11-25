<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;
use Exception;

class Owner
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
        try {
            if ((Article::whereSlug($request->slug)->first())->user_id == Auth::user()->id)
            {
                return $next($request);
            }
            else {
                return redirect(route('home'))->with('message', '編集権利ありません！');
            }
        }
        catch(Exception $e) {
            return redirect(route('home'))->with('message', '記事見つかれません！');
        }
    }
}
