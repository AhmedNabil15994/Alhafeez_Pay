<?php

namespace Modules\Invoice\Repositories\Dashboard;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Invoice\Entities\Transaction;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class TransactionRepository extends CrudRepository
{
    public function __construct(Transaction $tr)
    {
        $this->tr      = $tr;
    }

    /**
     * Prepare Data before save or edir
     *
     * @param array $data
     * @param \Illuminate\Http\Request $request
     * @param boolean $is_create
     * @return array
     */
    public function prepareData(array $data, Request $request, $is_create = true): array
    {
        return $data;
    }

    /*
    * Generate Datatable
    */
    public function QueryTable($request)
    {
        $query = $this->tr->withDeleted();

        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    public function ById(int $id)
    {
        return $this->tr->withDeleted()->findOrFail($id);
    }

    /*
    * Filteration for Datatable
    */
    public function filterDataTable($query, $request)
    {
        // Search cars by Created Dates
        // if (isset($request['req']['from']) && $request['req']['from'] != '') {
        //     $query->whereDate('created_at', '>=', $request['req']['from']);
        // }

        // if (isset($request['req']['to']) && $request['req']['to'] != '') {
        //     $query->whereDate('created_at', '<=', $request['req']['to']);
        // }

        // if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'only') {
        //     $query->onlyDeleted();
        // }

        // $query->when( !is_null($request->input("req.status")) , function($q) use ($request)
        // {
        //     $q->where('status', $request->input("req.status"));
        // })
        // ->when( !is_null($request->input("req.transaction_key")) , function($q) use ($request)
        // {
        //     $q->where('number', $request->input("req.transaction_key"));
        // })
        // ->when( !is_null($request->input("req.invoice_id")) , function($q) use ($request)
        // {
        //     $q->whereHas("invoice", function($q) use($request)
        //     {
        //         $q->where('id', $request->input("req.id"));
        //     });
        // })
        // ->when( !is_null($request->input("req.number")) , function($q) use ($request)
        // {
        //     $q->whereHas("invoice", function($q) use($request)
        //     {
        //         $q->where('number', $request->input("req.number"));
        //     });
        // })
        // ->when( !is_null($request->input("req.name")) , function($q) use ($request)
        // {
        //     $q->whereHas("invoice.user", function($q) use($request)
        //     {
        //         $q->where('name', $request->input("req.name"));
        //     });
        // })
        // ->when( !is_null($request->input("req.mobile")) , function($q) use ($request)
        // {
        //     $q->whereHas("invoice.user", function($q) use($request)
        //     {
        //         $q->where('mobile', $request->input("req.mobile"));
        //     });
        // });

        $query->when($request->invoice_id, function($q) use($request)
        {
            $q->where('invoice_id', $request->invoice_id);
        });

        return $query;
    }

}
