<div class="form-group">
    <label for="" class="form-label">{{__('invoice::dashboard.invoices.datatable.status')}} </label>
    <select name="status" class="select2">
        @foreach ([
            'valid' => __('invoice::dashboard.invoices.statuses.valid'),
            'disabled' => __('invoice::dashboard.invoices.statuses.disabled'),
            'expired' => __('invoice::dashboard.invoices.statuses.expired'),
        ] as $key => $value)
            <option value="{{$key}}"
            @isset($model)
            @if($model->status)
                @if($model->status == $key) @selected(true) @endif
            @endif
            @endisset
            >{{$value}}</option>
        @endforeach
    </select>
</div>

@if(request()->route()->getName()=='dashboard.invoices.edit')
<div class="form-group">
    <label for="" class="form-label">{{__('invoice::dashboard.invoices.datatable.status')}}</label>
    <select name="payment_status" id="" class="select2">
        @foreach (
            [
                'success' => __('invoice::dashboard.invoices.statuses.success'),
                'failed' => __('invoice::dashboard.invoices.statuses.failed'),
                'pending' => __('invoice::dashboard.invoices.statuses.pending'),
                'expired' => __('invoice::dashboard.invoices.statuses.expired'),
            ] as $key => $status)
            <option value="{{$key}}" {{$model->plugin ? ($model->plugin->payment_status==$key ? 'selected' : '') : ''}}>{{$status}}</option>
        @endforeach
    </select>
</div>
@endif
@isset($model)
@if($model && $model->trashed())
    {!! field()->checkBox('trash_restore',  __('apps::dashboard.datatable.form.restore') ) !!}
@endif
@endisset
