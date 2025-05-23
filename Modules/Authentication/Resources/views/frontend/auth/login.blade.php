@extends('authentication::master')
@section('title',__('authentication::dashboard.login.routes.index'))
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
    <form class="login-form" action="{{route('vendors.login')}}" method="post">
        @csrf
        <h3 class="form-title font-green">{{ __('authentication::dashboard.login.routes.index') }}</h3>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span> {{ __('authentication::frontend.login.validations.enter_email_password') }} </span>
        </div>
        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">{{ __('authentication::dashboard.login.form.email') }}</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="{{ __('authentication::dashboard.login.form.email') }}" name="email" value="{{old('email')}}" /> </div>
            @if ($errors->has('email'))
            <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
            @endif
        <div class="form-group {{$errors->has('password') ? ' has-error' : ''}}">
            <label class="control-label visible-ie8 visible-ie9">{{ __('authentication::dashboard.login.form.password') }}</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="{{ __('authentication::dashboard.login.form.password') }}" name="password" /> </div>
            @if ($errors->has('password'))
            <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        <div class="form-actions">
            <button type="submit" class="btn green uppercase">{{ __('authentication::dashboard.login.form.btn.login') }}</button>
            <label class="rememberme check mt-checkbox mt-checkbox-outline">
                <input type="checkbox" name="remember" value="1" />{{ __('authentication::frontend.login.remember') }}
                <span></span>
            </label>
            <a href="javascript:;" id="forget-password" class="forget-password">{{ __('authentication::frontend.login.forgot_password') }}</a>
        </div>
        <div class="login-options">

        </div>
        <div class="create-account">
            <p>
                <a href="javascript:;" id="register-btn" class="uppercase">{{ __('authentication::frontend.register.index') }}</a>
            </p>
        </div>
    </form>
    <!-- END LOGIN FORM -->
    <!-- BEGIN FORGOT PASSWORD FORM -->
    <form class="forget-form" action="{{route('vendors.forgot_password')}}" method="post">
        @csrf
        <h3 class="font-green">{{ __('authentication::frontend.login.forgot_password') }}</h3>
        <p> {{ __('authentication::frontend.login.forgot_password_desc') }} </p>
        <div class="form-group">
            <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" /> </div>
        <div class="form-actions">
            <button type="button" id="back-btn" class="btn green btn-outline">{{ __('authentication::frontend.register.form.back') }}</button>
            <button type="submit" class="btn btn-success uppercase pull-right">{{ __('authentication::frontend.register.form.submit') }}</button>
        </div>
    </form>
    <!-- END FORGOT PASSWORD FORM -->
    <!-- BEGIN REGISTRATION FORM -->
    <form class="register-form" id="register-form" action="{{route('vendors.register')}}" method="post">
        @csrf
        <h3 class="font-green">{{ __('authentication::frontend.register.index') }}</h3>

        <div id="bravo" class="text-center" style="display: none">
            <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
            <lord-icon
                src="https://cdn.lordicon.com/lupuorrc.json"
                trigger="loop"
                colors="primary:#121331,secondary:#08a88a"
                style="width:120px;height:120px">
            </lord-icon>
        </div>
        <div class="alert alert-danger" id="regiser-errors" style="display: none;"></div>
        <div class="alert alert-success" id="regiser-success" style="display: none;"></div>
        <div id="form-of-register">
            <p class="hint"> {{ __('authentication::frontend.register.desc') }} </p>
            <div class="form-group">
                <label class="control-label">{{ __('authentication::frontend.register.form.fullname') }}</label>
                <input class="form-control placeholder-no-fix" type="text" placeholder="{{ __('authentication::frontend.register.form.fullname') }}" name="name" /> </div>
            <div class="form-group">
                <label class="control-label">{{ __('authentication::dashboard.login.form.email') }}</label>
                <span id="register_email_message" class="text-danger"></span>
                <input class="form-control placeholder-no-fix" id="register_email" type="text" placeholder="{{ __('authentication::dashboard.login.form.email') }}" name="email" /> </div>
            <div class="form-group">
                <label class="control-label">{{ __('authentication::frontend.register.form.mobile') }}</label>
                <span id="register_mobile_message" class="text-danger"></span>
                <input class="form-control placeholder-no-fix" id="register_mobile" type="text" placeholder="{{ __('authentication::frontend.register.form.mobile') }}" name="mobile" /> </div>
            <div class="form-group">
                <label class="control-label">{{ __('authentication::dashboard.login.form.password') }}</label>
                <span id="register_password_message" class="text-danger"></span>
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="{{ __('authentication::dashboard.login.form.password') }}" name="password" /> </div>
            <div class="form-group">
                <label class="control-label">{{ __('authentication::frontend.register.form.re_password') }}</label>
                <span id="register_password_confirm_message" class="text-danger"></span>
                <input class="form-control placeholder-no-fix" type="password" id="register_password_confirm" autocomplete="off" placeholder="{{ __('authentication::frontend.register.form.re_password') }}" name="password_confirm" /> </div>
            <div class="form-group margin-top-20 margin-bottom-20">
                <label class="mt-checkbox mt-checkbox-outline">
                    <input type="checkbox" name="tnc" /> {{ __('authentication::frontend.register.form.i_agree') }}
                    <a href="javascript:;">{{ __('authentication::frontend.register.form.terms_of_service') }} </a> &
                    <a href="javascript:;">{{ __('authentication::frontend.register.form.privacy_policy') }} </a>
                    <span></span>
                </label>
                <div id="register_tnc_error"> </div>
            </div>
            <div class="form-actions">
                <button type="button" id="register-back-btn" class="btn green btn-outline">{{ __('authentication::frontend.register.form.back') }}</button>
                <button type="submit" id="register-submit-btn" class="btn btn-success uppercase pull-right">{{ __('authentication::frontend.register.form.submit') }}</button>
            </div>
        </div>
    </form>
    <!-- END REGISTRATION FORM -->
</div>
<div class="copyright">
    {{date('Y')}} - {{ __('apps::dashboard._layout.footer.copy_rights') }} &copy;
    <a target="_blank" href="https://www.tocaan.com/" class="font-white">Tocaan</a>
</div>
@endsection

@section('scripts')
@parent
<script>

// Variable to hold request
var request;

// Bind to the submit event of our form
$("#register-form").submit(function(event){

    // Prevent default posting of form - put here to work in case of errors
    event.preventDefault();

    // setup some local variables
    var $form = $(this);

    var registerFormAction = $form.attr('action');

    // Abort any pending request
    if (request) {
        request.abort();
    }

    // Let's select and cache all the fields
    var $inputs = $form.find("input, select, button, textarea");

    // Serialize the data in the form
    var serializedData = $form.serialize();

    // Let's disable the inputs for the duration of the Ajax request.
    // Note: we disable elements AFTER the form data has been serialized.
    // Disabled form elements will not be serialized.
    $inputs.prop("disabled", true);

    // Fire off the request to /form.php
    request = $.ajax({
        url: registerFormAction,
        type: "post",
        data: serializedData
    });

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        $("#regiser-errors").remove();
        $("#form-of-register").remove();
        $("#bravo").show();
        $("#regiser-success").show();
        $("#regiser-success").html(jqXHR.responseJSON.message);
        console.log(jqXHR.responseJSON);

    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        var register_errors = '';
        $.each(jqXHR.responseJSON.errors, function(index,jsonObject){

            jsonObject.filter(function( element ) {
                return element !== undefined;
            });

            $.each(jsonObject, function(key,val){
                if( val!=undefined && val!=null )
                {
                    register_errors += "<li>"+ val +"</li>";
                }
            });
        });

        if( register_errors!=null )
        {
            $("#regiser-errors").show();
            $("#regiser-errors").html(register_errors);
        }

        $inputs.prop("disabled", true);
    });

    // Callback handler that will be called regardless
    // if the request failed or succeeded
    request.always(function () {
        // Reenable the inputs
        $inputs.prop("disabled", false);
    });

});
</script>
@stop
