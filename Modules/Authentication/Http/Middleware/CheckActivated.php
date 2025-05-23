<?php

namespace Modules\Authentication\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckActivated
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
        
        if(auth()->check() && auth()->user()->is_active){
            return $next($request);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => __("authentication::api.status.not_active"),
            ], 405);
        }
        return redirect()->route("frontend.home")->withError( __("authentication::api.status.not_active"));

       
    }
}
