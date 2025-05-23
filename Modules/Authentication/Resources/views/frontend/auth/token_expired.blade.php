@extends('authentication::master')
@section('title',__('authentication::frontend.verify.verify_account'))
@section('content')
<!-- BEGIN LOGO -->
<div class="logo" >
    @if( !is_null(setting('logo')) )
    <img src="{{url(setting('logo'))}}" alt="" style="max-height:100px;" />
    @endif
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->
        <h3 class="form-title font-green">{{ __('authentication::frontend.verify.verify_account') }}</h3>
        <h1 class="text-danger text-center" style="padding: 8px; font-size:48px;"><i class="fa fa-times-circle"></i></h1>
        <p class="text-center">
            {{ __('authentication::frontend.verify.token_expired') }}
        </p>
        <div class="p-2 text-center">
            <button class="btn btn-primary" data-email="{{request()->email}}" id="re-send"><i class="fa fa-refresh"></i> {{ __('authentication::frontend.verify.generate_link') }}</button>
        </div>
</div>
<div class="copyright">
    {{date('Y')}} - {{ __('apps::dashboard._layout.footer.copy_rights') }} &copy;
    <a target="_blank" href="https://www.tocaan.com/" class="font-white">Tocaan</a>
</div>
@endsection

@section('scripts')
@parent
<script>
$("#re-send").on('click', function(e)
{
    var resend_btn = $(this);
    resend_btn.html("<i class='fa fa-refresh'></i> {{ __('authentication::frontend.verify.loading') }}");
    resend_btn.prop("disabled", true);
    e.preventDefault();
    $.post("{{route('vendors.re-generate')}}", {"_token": "{{csrf_token()}}", "email": $(this).attr("data-email")}, function(data)
    {
        if( data['success']==true )
        {
            resend_btn.html("<i class='fa fa-refresh'></i> {{ __('authentication::frontend.verify.generate_link') }}");
            resend_btn.parent('div').append("<br /><div role='alert' class='alert alert-success'>{{ __('authentication::frontend.verify.link_sent') }}</div>");
        }
    })
})
</script>
@stop
