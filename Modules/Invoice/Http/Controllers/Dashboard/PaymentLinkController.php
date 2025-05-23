<?php

namespace Modules\Invoice\Http\Controllers\Dashboard;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Modules\User\Entities\User;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Illuminate\Support\Facades\Hash;
use Modules\Invoice\Entities\PaymentLink as Model;
use Modules\Core\Traits\Dashboard\CrudDashboardController;
use Modules\Invoice\Transformers\Dashboard\PaymentLinkResource;
use Modules\Invoice\Repositories\Dashboard\PaymentLinkRepository as PaymentLink;

class PaymentLinkController extends Controller
{
    use CrudDashboardController;

    public function __construct(PaymentLink $link)
    {
        $this->link = $link;
    }

    public function index()
    {
        return view('invoice::dashboard.invoices.paymentlinks.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->link->QueryTable($request));

        $datatable['data'] = PaymentLinkResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function generateToken(User $user)
    {
        $expires_at = now()->addDays( setting('payment_link', 'days') ?? 30);
        return $user->custom_tokens()->create(
            [
                'token_for' => 'payment_link',
                'token' => hash('sha1', Hash::make( Str::random(64) . time() ) ),
                'expires_at' => $expires_at,
            ]
            );
    }

    public function edit($id)
    {
        $model = $this->link->ById($id);

        return view('invoice::dashboard.invoices.paymentlinks.edit', compact("model"));
    }

    public function update(Request $request, $id)
    {
        try {
            $model = $this->link->ById($id);

            $data = ['status' => $request->status];

            if( !is_null($request->trash_restore) )
            {
                $data = array_merge($data, ['deleted_at' => null]);
            }

            $update = $model->update($data);

            if ($update) {
                return Response()->json([true , __('apps::dashboard.messages.updated')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function destroy($id)
    {
        try {
            $model = Model::findOrFail($id);
            $delete = $model->delete($id);

            if ($delete) {
                return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            $deleteSelected = $this->invoice->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
