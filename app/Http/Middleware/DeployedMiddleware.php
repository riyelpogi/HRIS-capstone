<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DeployedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         if(auth()->user()->deployed != null){
            return $next($request);
        }else{
            return redirect(route('employee.dashboard'))->with('failed', 'Failed, you can access this part of a website on your deployment date.');
        }
    }
}
