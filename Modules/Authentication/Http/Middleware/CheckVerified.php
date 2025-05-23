<?php

namespace Modules\Authentication\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckVerified
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
        // dd(auth()->id());
        
        if (auth()->check() && auth()->user()->is_verified) {
            return $next($request);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => __("authentication::api.status.not_verified"),
            ], 406);
        }

        return redirect()->route("frontend.user.verify")->withError(__("authentication::api.status.not_verifed"));
    }
}
