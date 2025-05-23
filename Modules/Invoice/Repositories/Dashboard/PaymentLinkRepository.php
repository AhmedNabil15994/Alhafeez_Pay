<?php

namespace Modules\Invoice\Repositories\Dashboard;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Invoice\Entities\PaymentLink;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class PaymentLinkRepository extends CrudRepository
{
    public function __construct(PaymentLink $link)
    {
        $this->link      = $link;
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
        $query = $this->link->withDeleted();

        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    public function ById(int $id)
    {
        return $this->link->withDeleted()->findOrFail($id);
    }

    /*
    * Filteration for Datatable
    */
    public function filterDataTable($query, $request)
    {
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

        if ($request->has("req.status")) {
            $query->where("status", $request->input("req.status"));
        }

        if ($request->has("status")) {
            $query->where("status", $request->input("status"));
        }
        return $query;
    }

}
