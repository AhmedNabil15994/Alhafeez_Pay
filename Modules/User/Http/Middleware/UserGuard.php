<?php
namespace Modules\User\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$type)
    {
        if (\in_array(auth()->user()->type, $type)) {
            return $next($request);
        }

        if ($request->ajax() || $request->wantsJson()) {
            $res =  [
                'success' => false,
                'message' => __("user::api.type.not_allow_type"),
            ];
            return response()->json($res, 403);
        }

        abort(403);
    }
}
