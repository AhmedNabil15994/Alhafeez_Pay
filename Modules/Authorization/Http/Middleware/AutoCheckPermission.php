<?php

namespace Modules\Authorization\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Modules\Authorization\Entities\Permission;

class AutoCheckPermission
{
    private $actions = [
        'create' => 'add',
        'store' => 'add',
        'edit' => 'edit',
        'update' => 'edit',
        'deletes' => 'delete',
        'destroy' => 'delete',
        'index' => 'show',
        'datatable' => 'show',
        'show' => 'show',
        "dashboard"=>"access" ,
        "send"     => "show",
        "change_status"=> "show",
        "payment_links"=> "show",
        "transactions"=> "show"
    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $route = $request->route()->getName();

        // dd($route);
        $path  = explode(".", $route);
        $count = count($path);

        if ($count ==  2 && !$this->checkPathTwo($path)) {
            abort(403);
        }
        if ($count ==  3 && ! $this->checkPathThree($path)) {
            abort(403);
        }
        if ($count ==  4 && ! $this->checkPathFour($path)) {
            abort(403);
        }

        return $next($request);
    }

    protected function checkPathTwo($path)
    {
        if (isset($this->actions[$path[0]])) {
            $name = $path[0] . "_". $this->actions[$path[0]];
            return $this->checkPermission($name);
        }
        return false;
    }

    protected function checkPathThree($path)
    {
        if (isset($this->actions[$path[2]])) {
            $name =$this->actions[$path[2]] . "_". $path[1];
            return $this->checkPermission($name);
        }
        return false;
    }

    protected function checkPathFour($path)
    {
        if (isset($this->actions[$path[3]])) {
            $name =$this->actions[$path[3]] . "_". $path[1];
            return $this->checkPermission($name);
        }
        return false;
    }

    public function checkPermission($permission_name)
    {
        $result =  auth()->user()->can($permission_name);
        if(!$result){
           $result= auth()->user()->can(Str::plural($permission_name));
        }
        return $result;
    }
}
