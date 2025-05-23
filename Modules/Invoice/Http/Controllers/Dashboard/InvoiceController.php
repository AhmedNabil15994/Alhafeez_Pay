<?php

namespace Modules\Invoice\Http\Controllers\Dashboard;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Modules\User\Entities\User;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Illuminate\Support\Facades\Hash;
use Modules\Invoice\Entities\PaymentLink;
use Modules\Invoice\Entities\Invoice as Model;
use Modules\Core\Traits\Dashboard\CrudDashboardController;
use Modules\Invoice\Http\Requests\Dashboard\InvoiceRequest;
use Modules\Invoice\Transformers\Dashboard\InvoiceResource;
use Modules\Invoice\Repositories\Dashboard\InvoiceRepository as Invoice;

class InvoiceController extends Controller
{
    use CrudDashboardController;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function index(Request $request)
    {
        $this->authorize('show_invoices');
        return view('invoice::dashboard.invoices.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->invoice->QueryTable($request));

        $datatable['data'] = InvoiceResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        $this->authorize('add_invoices');
        $model = new Model;

        return view('invoice::dashboard.invoices.create', compact("model"));
    }

    public function store(Request $request)
    {
        $this->authorize('add_invoices');

        $errors = [];
        if( is_null($request->mobile) )
        {
            $errors[] = __('invoice::dashboard.validation.mobile_required');
        }

        if( is_null($request->reference_no) )
        {
            $errors[] = __('invoice::dashboard.validation.reference_no_required');
        }

        if( is_null($request->amount) )
        {
            $errors[] = __('invoice::dashboard.validation.amount_required');
        }

        if( !is_numeric($request->amount) )
        {
            $errors[] = __('invoice::dashboard.validation.amount_not_numeric');
        }

        if( count($errors) > 0 )
        {
            $errors_html = '';
            foreach($errors as $err)
            {
                $errors_html .= "<li>".$err."</li>";
            }

            return
            [
                'success' => false,
                'errors' => $errors_html
            ];
        }

        $user = User::updateOrCreate(
            [
                'mobile' => $request->mobile
            ],
            [
                'name' => $request->name ?? 'Client',
                'email' => $request->email ?? 'client-'.$request->mobile.'@example.com',
                'password' => Hash::make(Str::random(12))
            ]
            );

        $invoice = $user->invoices()->create(
            [
                'number' => Str::random(6) .'-'. substr(time(), 6),
                'amount' => $request->amount,
                'total' => $request->amount,
                'vat_amount' => 0,
                'discount_amount' => 0,
                'due_at' => now()->addDays( setting('payment_link', 'days') ?? 30)
            ]
            );

        $invoice->plugin()->create(
            [
                'reference_no' => $request->reference_no,
                // 'channel' => $request->channel.':'.$request->channel_name,
                'note' => $request->note,
                'admin_id' => auth()->user()->id
            ]
            );

        $token = $this->generateToken($user);

        $route = route('web.invoice.payment-link',
        [
            'number' => $invoice->number,
            'id' => $invoice->id,
            'token' => $token->token,
        ]);

        $payment_link = app('bitly')->getUrl($route);

        PaymentLink::updateOrCreate(
            [
                'invoice_id' => $invoice->id
            ],
            [
                'original_link' => $route,
                'short_link' => $payment_link,
                'custom_token_id' => $token->id
            ]
        );

        return [
            'success' => true,
            'link' => $payment_link,
            'mobile' => $request->mobile ?? ''
        ];

        //web.invoice.payment-link
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

    public function show($id, Request $request)
    {
        $this->authorize('show_invoices');

        $model = Model::with(['link', 'transactions'])->findOrFail($id);

        if( $request->action=='print' )
        {
            return view('invoice::dashboard.invoices.print', compact('model'));
        }

        return view('invoice::dashboard.invoices.show', compact('model'));
    }

    public function edit($id)
    {
        $this->authorize('edit_invoices');

        $model = $this->invoice->ById($id);

        return view('invoice::dashboard.invoices.edit', compact("model"));
    }

    public function update(InvoiceRequest $request, $id)
    {
        $this->authorize('edit_invoices');

        try {
            $model = $this->invoice->ById($id);
            $update = $model->update($request->toArray());

            if ($update) {

                $model->plugin->payment_status = $request->payment_status;
                $model->plugin->save();

                $invoice_status = 'unpaid';
                if( $request->payment_status=='success' ){ $invoice_status = 'paid'; }
                else if( $request->payment_status=='expired' ){ $invoice_status = 'canceled'; }

                $model->status = $invoice_status;
                $model->save();


                return Response()->json([true , __('apps::dashboard.messages.updated')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function destroy($id)
    {
        $this->authorize('delete_invoices');

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
