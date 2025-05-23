<div class="row">
@if(\App\Helpers\Parents::ParentOrChild(auth()->guard('vendor')->user())->subscription->trial_taken=="in_trial")
    <span class="label label-warning">{{ trans('subscription::frontend.types.trial') }}</span>
@else
    <span class="label label-success">{{ trans('subscription::frontend.types.real') }}</span>
@endif

<strong>{{ trans('subscription::frontend.expires_at') }}</strong>:
{{\Carbon\Carbon::parse(\App\Helpers\Parents::ParentOrChild(auth()->guard('vendor')->user())->subscription->expires_at)->format('Y-m-d')}}
</div>
