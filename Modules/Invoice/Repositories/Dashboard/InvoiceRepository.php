<?php

namespace Modules\Invoice\Repositories\Dashboard;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Invoice\Entities\Invoice;
use Modules\Core\Repositories\Dashboard\CrudRepository;
use Modules\Invoice\Http\Requests\Dashboard\InvoiceRequest;

class InvoiceRepository extends CrudRepository
{
    public function __construct(Invoice $invoice)
    {
        $this->invoice      = $invoice;
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
        if( auth()->user()->can('his_own_invoices_only') )
        {
            $query = $this->invoice->whereHas('plugin', function($q)
            {
                $q->where('admin_id', auth()->user()->id);
            })->withDeleted();
        } else {
            $query = $this->invoice->withDeleted();
        }


        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    public function ById(int $id)
    {
        return $this->invoice->findOrFail($id);
    }

    /*
    * Create New Object & Insert to DB
    */
    public function create($request)
    {
        DB::beginTransaction();

        try {
            $data = $request->except(["_token"]);
            $data = array_merge($data,
            [
                'number' => config('subscriptions.prefix') . Str::random(8),
                'vat_amount' => $request->vat_amount ?? 0,
                'discount_amount' => $request->discount_amount ?? 0,
            ]);

            $invoice = $this->invoice->create($data);

            DB::commit();
            return $invoice;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


    /*
    * Filteration for Datatable
    */
    public function filterDataTable($query, $request)
    {
        $agent_ids = null;

        if( !is_null($request->input('req.agents_hidden_filter')) )
        {
            $agent_ids = explode("|", $request->input('req.agents_hidden_filter'));
        }

        // Search cars by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '') {
            $query->whereDate('created_at', '>=', $request['req']['from']);
        }

        if (isset($request['req']['to']) && $request['req']['to'] != '') {
            $query->whereDate('created_at', '<=', $request['req']['to']);
        }

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'only') {
            $query->onlyDeleted();
        }

        $query->when( !is_null($request->input("req.number")) , function($q) use ($request)
        {
            $q->where('number', $request->input("req.number"));
        })
        ->when( !is_null($request->input("req.status")) , function($q) use ($request)
        {
            $q->whereHas("plugin", function($q) use($request)
            {
                $q->where('payment_status', $request->input("req.status"));
            });
        })
        ->when( !is_null($request->input("req.reference_no")) , function($q) use ($request)
        {
            $q->whereHas("plugin", function($q) use($request)
            {
                $q->where('reference_no', $request->input("req.reference_no"));
            });
        })
        ->when( !is_null($request->input("req.name")) , function($q) use ($request)
        {
            $q->whereHas("user", function($q) use($request)
            {
                $q->where('name', $request->input("req.name"));
            });
        })
        ->when( !is_null($request->input("req.name")) , function($q) use ($request)
        {
            $q->whereHas("user", function($q) use($request)
            {
                $q->where('name', $request->input("req.name"));
            });
        })
        ->when( !is_null($agent_ids) , function($q) use ($agent_ids)
        {
            if( is_array($agent_ids) && is_countable($agent_ids) && count($agent_ids) > 0 )
            {
                $q->whereHas("plugin", function($q) use($agent_ids)
                {
                    $q->whereIn('admin_id', $agent_ids);
                });
            }
        });

        return $query;
    }

}
