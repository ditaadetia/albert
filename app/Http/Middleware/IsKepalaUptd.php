<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsKepalaUptd
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!auth()->check() || auth()->user()->jabatan !== 'kepala uptd'){
            abort(403);
        }
        return $next($request);
    }
}
