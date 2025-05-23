@extends('authentication::master')
@section('title', __('invoice::frontend.invoices.failure'))

@section('content')
<body class="login">
    <div class="content text-center">
        <span class="holder" style="margin-top:15px;max-height:100px;">
            <img src="{{url(setting('logo'))}}" style="height: 15rem;">
        </span>
        <h3><span class="text-danger">{{__('invoice::frontend.invoices.failure')}}</span></h3>
        <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
            <lord-icon
                src="https://cdn.lordicon.com/hrqwmuhr.json"
                trigger="loop"
                colors="primary:#f4dc9c,secondary:#e83a30"
                style="width:90px;height:90px">
            </lord-icon>
        <p>{{__('invoice::frontend.invoices.failure_desc')}}</p>
        <div class="margin-top-3">

        </div>
        @include('invoice::frontend.partials.form_button', ['button_title' => __('invoice::frontend.invoices.try_again'), 'counter' => true])
    </div>
</body>

@include('invoice::frontend.partials.css')
@endsection
