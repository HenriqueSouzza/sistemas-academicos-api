<?php

namespace App\Http\Middleware;

use Closure;
// use Gate;

class CheckUserACL
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
        //obtem a controller e a ação 
        $ability = explode('\\', $request->route()->getActionName())[4];
    
        if(! Gate::forUser($request->user())->allows($ability))
        {
            return response()->json(['response' => 'Unauthorized'])->setStatusCode(403);
        }

        return $next($request);
    }
}
