<?php
namespace Modules\User\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\User\Enum\UserType;

class AllowShowUserGuard
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
        $auth    = auth()->user();
        $userId  = $request->route('userId');
        
        if ($request->ajax() || $request->wantsJson()) {
            if ($auth) {
                if ($auth->type == UserType::USER  &&  $auth->id == $userId) {
                    return $next($request);
                }

                if ($auth->children()->where("users.id", $userId)->exists()) {
                    return $next($request);
                }
            }

            $res =  [
                'success' => false,
                'message' => __("ensaan::api.circle.not_have_permission"),
            ];
            return response()->json($res, 403);
        }
     

        abort(403);
    }
}
