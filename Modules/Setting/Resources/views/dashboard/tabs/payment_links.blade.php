<div class="tab-pane fade" id="payment_links">
    <h3 class="page-title">{{ __('setting::dashboard.settings.form.tabs.payment_links') }}</h3>
    <div class="col-md-10">
        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.payment_link_expiration_in_days') }}
            </label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="payment_link[days]" value="{{setting('payment_link', 'days')}}">
            </div>
        </div>
    </div>
</div>
