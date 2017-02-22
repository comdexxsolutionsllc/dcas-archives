<?php

namespace App\Modules\Support\Http\Middleware;

use Closure;

class MustBeInSupportAccessGroup
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
        if(!\Auth::check()) abort(403, 'Unauthorized action.'); 
          
        return $next($request);
    }
}
