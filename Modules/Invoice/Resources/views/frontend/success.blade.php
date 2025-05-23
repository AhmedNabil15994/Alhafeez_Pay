@extends('authentication::master')
@section('title', __('invoice::frontend.invoices.success'))

@section('content')
<body class="login">
    <div class="content text-center">
        <span class="holder" style="margin-top:15px;max-height:100px;">
            <img src="{{url(setting('logo'))}}" style="height: 15rem;">
        </span>
        <h3>{{__('invoice::frontend.invoices.success')}}</h3>
        <p>{{__('invoice::dashboard.invoices.datatable.reference_no')}} : {{!is_null($invoice->plugin) ? $invoice->plugin->reference_no : '--'}}</p>
        <p>{{__('invoice::frontend.invoices.amount')}} : {{!is_null($invoice->amount) ? $invoice->amount : '0'}}</p>
        <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
            <lord-icon
                src="https://cdn.lordicon.com/lupuorrc.json"
                trigger="loop"
                colors="primary:#121331,secondary:#08a88a"
                style="width:90px;height:90px">
            </lord-icon>
        <p>{{__('invoice::frontend.invoices.success_desc', ['app_name' => setting('app_name', app()->getLocale())])}}</p>
        <div class="margin-top-3">


        </div>
    </div>
</body>

@include('invoice::frontend.partials.css')
@endsection
