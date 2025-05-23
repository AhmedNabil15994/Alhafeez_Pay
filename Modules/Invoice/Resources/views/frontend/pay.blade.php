@extends('authentication::master')
@section('title', __('invoice::frontend.invoices.pay_invoice'))

@section('content')
<body class="login">
    <div class="content text-center">
        <span class="holder" style="margin-top:15px;max-height:100px;">
            <img src="{{url(setting('logo'))}}" style="height: 15rem;">
        </span>
{{--        <h3>{{__('invoice::frontend.invoices.pay_invoice')}}</h3>--}}
        <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
            <lord-icon
                src="https://cdn.lordicon.com/qhviklyi.json"
                trigger="loop"
                colors="primary:#121331,secondary:#08a88a"
                style="width:90px;height:90px">
            </lord-icon>
{{--        <p>{{__('invoice::frontend.invoices.pay_invoice_desc')}}</p>--}}

        <div class="margin-top-3">
            <div class="text-center">
                <h4> {{__('invoice::frontend.invoices.invoice_information')}}</h4>
            </div>
            <div class="table-scrollable">
                <table class="table table-hover table-light">
                    <tbody>
{{--                        <tr><td>{{__('invoice::frontend.invoices.number')}}</td><td>{{$invoice->number}}</td></tr>--}}
                        <tr><td>{{__('invoice::frontend.invoices.amount')}}</td><td>{{$invoice->amount}} <sub>{{__('apps::dashboard.kwd')}}</sub></td></tr>
                        <tr><td>{{__('invoice::frontend.invoices.note')}}</td><td>{{$invoice->plugin ? $invoice->plugin->note : 'N/A'}}</td></tr>
                        <tr><td>{{__('invoice::frontend.invoices.issuing_date')}}</td><td>{{\Carbon\Carbon::parse($invoice->created_at)->format('Y-m-d')}}</td></tr>
                        <tr><td>{{__('invoice::dashboard.invoices.datatable.reference_no')}}</td><td>{{!is_null($invoice->plugin) ? $invoice->plugin->reference_no : '--'}}</td></tr>

                    </tbody>
                </table>
            </div>
        </div>

        <div class="margin-top-3">
            <div class="text-center">
                <h4><i class="fa fa-user"></i> {{__('invoice::frontend.invoices.client_information')}}</h4>
            </div>
            <div class="table-scrollable">
                <table class="table table-hover table-light">
                    <tbody>
                        <tr><td>{{__('invoice::frontend.invoices.client_name')}}</td><td>{{$invoice->user ? $invoice->user->name : '--'}}</td></tr>
                        <tr><td>{{__('invoice::frontend.invoices.client_phone')}}</td><td>{{$invoice->user ? $invoice->user->mobile : '--'}}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        @include('invoice::frontend.partials.form_button')
    </div>


</body>

@include('invoice::frontend.partials.css')
@endsection
