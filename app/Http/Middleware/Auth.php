<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class Auth
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
        $codigo = $request->session()->get('codigo','');
        $user = User::where('codigo', $codigo)->first();
        if (!$user) {
            return redirect('/login?redirectTo='.$request->path());
        }

        return $next($request);
    }
}
