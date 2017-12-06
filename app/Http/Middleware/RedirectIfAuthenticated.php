<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Usuario;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $code = $request->session()->get('codigo','');
        $user = Usuario::where('codigo', $code)->first();
        if ($user) {
            return redirect('/');
        }

        return $next($request);
    }
}
