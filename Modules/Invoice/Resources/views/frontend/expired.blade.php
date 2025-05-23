@extends('authentication::master')
@section('title', __('invoice::frontend.invoices.expired_link'))

@section('content')
<body class="login">
    <div class="content text-center">
        <span class="holder" style="margin-top:15px;max-height:100px;">
            <img src="{{url(setting('logo'))}}" style="height: 15rem;">
        </span>
        <h3>{{__('invoice::frontend.invoices.expired_link')}}</h3>
        <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
            <lord-icon
                src="https://cdn.lordicon.com/tdrtiskw.json"
                trigger="loop"
                colors="primary:#121331,secondary:#08a88a"
                style="width:90px;height:90px">
            </lord-icon>
        <p>{{__('invoice::frontend.invoices.expired_link_desc')}}</p>
    </div>
</body>

@include('invoice::frontend.partials.css')
@endsection
