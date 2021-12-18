<?php

namespace App\Http\Middleware;

use App\Http\Controllers\ProductController;
use Closure;
use Illuminate\Http\Request;

class SkipTokenAuth
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

        if ($request->bearerToken() == null)

            return (new ProductController)->getOneProduct($request->route()->parameter('id'));
        else

            return $next($request);
    }
}
