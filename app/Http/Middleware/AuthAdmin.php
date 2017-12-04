<?php

namespace App\Http\Middleware;

use Closure;
use App\Usuario;

class AuthAdmin
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
        $code = $request->session()->get('codigo','');
        $user = Usuario::where('codigo', $code)->first();
        if (!$code || !$user->admin) {
            return redirect('/');
        }

        return $next($request);
    }
}
