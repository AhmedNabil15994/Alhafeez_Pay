<?php

namespace Modules\Apps\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\User\Entities\User;
use Modules\User\Enum\UserType;
use Illuminate\Routing\Controller;
use Modules\Ensaan\Entities\Circle;
use Modules\Ensaan\Entities\Course;
use Modules\Ensaan\Entities\Mosque;
use Modules\Ensaan\Entities\CircleQuiz;
use Modules\Authorization\Entities\Role;
use Modules\Ensaan\Entities\CircleAttach;
use Modules\Ensaan\Entities\CircleAttend;

class DashboardController extends Controller
{
    public function index()
    {
        return view('apps::frontend.index');
    }

    public function ajaxFindClientAutoComplete(Request $request)
    {
        if( is_null($request->s) )
        {
            return view('apps::frontend.partials.no_records')->render();
        }

        if( is_null($user = User::whereType(UserType::CIVIL)->where('id_number', $request->s)->whereNull('deleted_at')->first()) )
        {
            return view('apps::frontend.partials.no_records')->render();
        }

        return view('apps::frontend.partials.autocomplete_results', compact('user'))->render();
    }
}
