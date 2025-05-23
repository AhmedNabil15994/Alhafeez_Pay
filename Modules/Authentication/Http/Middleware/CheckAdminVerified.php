<?php

namespace Modules\Authentication\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdminVerified
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
        
        if (auth()->check() && auth()->user()->admin_approved) {
            return $next($request);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => __("authentication::api.status.not_admin_verified"),
            ], 407);
        }

        return redirect()->route("frontend.user.verify")->withError(__("authentication::api.status.not_admin_verified"));
    }
}
