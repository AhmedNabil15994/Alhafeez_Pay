<div class="@if(is_rtl()=='rtl') text-right @else text-left @endif">
    <h4><i class="fa fa-user"></i> {{__('invoice::frontend.invoices.transaction_information')}}</h4>
</div>
<div class="table-scrollable">
    <table class="table table-hover table-light">
        <tbody>
            <tr><td>{{__('invoice::frontend.invoices.transaction_id')}}</td><td>{{$invoice->last_not_pending_transaction ? (explode('-', $invoice->last_not_pending_transaction->number)[3] ?? explode('-', $invoice->last_not_pending_transaction->number)) : '--'}}</td></tr>
            <tr><td>{{__('invoice::frontend.invoices.amount')}}</td><td>{{$invoice->amount}} <sub>{{__('apps::dashboard.kwd')}}</sub></td></tr>
            <tr><td>{{__('invoice::frontend.invoices.date')}}</td><td>{{date('Y-m-d')}}</sub></td></tr>
            <tr><td>{{__('invoice::frontend.invoices.time')}}</td><td>{{date('H:i:s')}}</sub></td></tr>
        </tbody>
    </table>
</div>
