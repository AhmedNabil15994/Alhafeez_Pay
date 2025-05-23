@extends('authentication::master')
@section('title', __('invoice::frontend.invoices.already_paid'))

@section('content')
<body class="login">
    <div class="content text-center">
        <span class="holder" style="margin-top:15px;max-height:100px;">
            <img src="{{url(setting('logo'))}}" style="height: 15rem;">
        </span>
        <h3>{{__('invoice::frontend.invoices.already_paid')}}</h3>
        <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
            <lord-icon
                src="https://cdn.lordicon.com/nocovwne.json"
                trigger="loop"
                colors="primary:#121331,secondary:#08a88a"
                style="width:90px;height:90px">
            </lord-icon>
        <p>{{__('invoice::frontend.invoices.already_paid_desc', ['app_name' => setting('app_name', app()->getLocale())])}}</p>
        <div class="margin-top-3">
            {{-- <div class="text-center">
                <h4><i class="fa fa-user"></i> {{__('invoice::frontend.invoices.transaction_information')}}</h4>
            </div> --}}
            <div class="table-scrollable">
                {{-- <table class="table table-hover table-light">
                    <tbody>
                        <tr><td>{{__('invoice::frontend.invoices.transaction_id')}}</td><td>{{$invoice->last_not_pending_transaction ? (explode('-', $invoice->last_not_pending_transaction->number)[3] ?? explode('-', $invoice->last_not_pending_transaction->number)) : '--'}}</td></tr>
                        <tr><td>{{__('invoice::frontend.invoices.amount')}}</td><td>{{$invoice->amount}} <sub>{{__('apps::dashboard.kwd')}}</sub></td></tr>
                    </tbody>
                </table> --}}
            </div>
        </div>
    </div>
</body>

@include('invoice::frontend.partials.css')
@endsection
