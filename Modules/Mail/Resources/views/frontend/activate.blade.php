@extends('mail::master')
@section('title')
{!! trans('mail::frontend.verify_account.activate_your_membership', ['app_name' => setting('app_name', app()->getLocale())]) !!}
@endsection
@section('content')

<table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
    <!-- Body content -->
    <tr>
      <td class="content-cell">
        <div class="f-fallback">
          <h1>{{__('mail::frontend.verify_account.welcome', ['name' => $user->name])}}</h1>
          <p>{{__('mail::frontend.verify_account.thank_you_register_line_1') }}</p>
          <p>{{__('mail::frontend.verify_account.thank_you_register_line_2') }}</p>
          <!-- Action -->
          <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
              <td align="center">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                  <tr>
                    <td align="center">
                      <a href="{{ route('vendors.verify', ['token' => $user->email_verify_token, 'email' => $user->email]) }}" class="f-fallback button button--green" target="_blank">{{ trans('mail::frontend.verify_account.click_to_verify') }} →</a>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
  </table>

@endsection
