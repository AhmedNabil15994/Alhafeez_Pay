<?php

namespace Modules\Invoice\Http\Controllers\Dashboard;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Modules\User\Entities\User;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Illuminate\Support\Facades\Hash;
use App\Tocaan\Payments\Models\Transaction as Model;
use Modules\Core\Traits\Dashboard\CrudDashboardController;
use Modules\Invoice\Transformers\Dashboard\TransactionResource;
use Modules\Invoice\Repositories\Dashboard\TransactionRepository as Transaction;

class TransactionController extends Controller
{
    use CrudDashboardController;

    public function __construct(Transaction $tr)
    {
        $this->tr = $tr;
    }

    public function index()
    {
        return view('invoice::dashboard.invoices.transactions.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->tr->QueryTable($request));

        $datatable['data'] = TransactionResource::collection($datatable['data']);

        return Response()->json($datatable);
    }
}
