<?php

namespace Modules\Apps\Http\Controllers\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\User\Entities\User;
use Modules\User\Enum\UserType;
use Illuminate\Routing\Controller;
use Modules\Invoice\Entities\Feed;
use Modules\Ensaan\Entities\Circle;
use Modules\Ensaan\Entities\Course;
use Modules\Ensaan\Entities\Mosque;
use Modules\Invoice\Entities\Invoice;
use Modules\Ensaan\Entities\CircleQuiz;
use Modules\Authorization\Entities\Role;
use Modules\Ensaan\Entities\CircleAttach;
use Modules\Ensaan\Entities\CircleAttend;
use Modules\Invoice\Entities\Transaction;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $data['sales'] = Invoice::whereStatus('paid')->whereMonth('created_at', Carbon::now()->month)->sum('total');
        $data['invoices'] = Invoice::whereStatus('paid')->whereMonth('created_at', Carbon::now()->month)->count();
        $data['transactions']['success'] = Transaction::whereStatus('complete')->whereMonth('created_at', Carbon::now()->month)->count();
        $data['transactions']['failed'] = Transaction::whereStatus('incomplete')->whereMonth('created_at', Carbon::now()->month)->count();

        $year = date('Y');
        $month = date('m');

        $dt = Carbon::createFromDate($year, $month);

        $charts = [];
        for($i=1; $i <= $dt->daysInMonth; $i++)
        {
            $date = $year.'-'.$month.'-'.$i;

            $charts[] =
            [
                'day' => $date,
                'all_invoices' => Invoice::whereDate('created_at', Carbon::parse($date))->count(),
                'paid' => Invoice::whereDate('created_at', Carbon::parse($date))->where('status', 'paid')->count(),
                'unpaid' => Invoice::whereDate('created_at', Carbon::parse($date))->where('status', 'unpaid')->count(),
            ];
        }

        $data['charts'] = json_encode($charts);

        $data['feeds'] = Feed::whereMonth('created_at', Carbon::now()->month)->orderBy('id', 'desc')->cursor();
        $data['latest_invoices'] = Invoice::whereMonth('created_at', Carbon::now()->month)->orderBy('id', 'desc')->take(50)->cursor();
        // charts
        return view('apps::dashboard.index', compact("data" ));
    }

    private function getCountUsers($request)
    {
        return $this->filter($request, ( new User())->baseType(UserType::USER) )->count();
    }

    private function filter($request, $model)
    {

        return $model->where(function ($query) use ($request) {

            // Search Users by Created Dates
            if ($request->from)
                $query->whereDate('created_at', '>=', $request->from);

            if ($request->to)
                $query->whereDate('created_at', '<=', $request->to);

        });
    }
}
