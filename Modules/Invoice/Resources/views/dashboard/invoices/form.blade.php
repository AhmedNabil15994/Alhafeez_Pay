<div class="form-group">
    <label for="" class="form-label">{{__('invoice::dashboard.invoices.datatable.client_name')}}</label>
    <input type="text" pattern="[a-zA-Z ]{1,}" name="name" class="form-control" value="@isset($model){{$model->user ? $model->user->name : old('name')}}@endisset">
</div>

<div class="form-group">
    <label for="" class="form-label">{{__('invoice::dashboard.invoices.datatable.client_phone')}} <span class="text-danger">*</span></label>
    <input type="text" name="mobile" class="form-control" value="@isset($model){{$model->user ? $model->user->mobile : old('mobile')}}@endisset" required>
</div>

<div class="form-group">
    <label for="" class="form-label">{{__('invoice::dashboard.invoices.datatable.amount')}} <sub>{{__('apps::dashboard.kwd')}}</sub> <span class="text-danger">*</span></label>
    <input type="text" name="amount" class="form-control" value="@isset($model){{$model->amount ?? old('amount')}}@endisset" required>
</div>

<div class="form-group">
    <label for="" class="form-label">{{__('invoice::dashboard.invoices.datatable.reference_no')}} <span class="text-danger">*</span></label>
    <input type="text" name="reference_no" class="form-control" value="@isset($model){{$model->plugin ? $model->plugin->reference_no : old('reference_no')}}@endisset" required>
</div>

<div class="form-group">
    <label for="" class="form-label">{{__('invoice::dashboard.invoices.datatable.note')}} </label>
    <textarea class="form-control" name="note" cols="4">@isset($model){{$model->user ? $model->plugin->note : old('note')}}@endisset</textarea>
</div>

{{-- <div class="form-group">
    <label for="" class="form-label">{{__('invoice::dashboard.invoices.datatable.channel')}} </label>
    <select name="channel" id="channel" class="select2">
        @foreach (__('invoice::dashboard.invoices.channels') as $key => $value)
            <option value="{{$key}}"
            @isset($model)
            @if($model->plugin)
                @if(explode(":", $model->plugin->channel)[0] == $key) @selected(true) @endif
            @endif
            @endisset
            >{{$value}}</option>
        @endforeach
    </select>
    <div style="padding-top: 4px; display:none" id="other_channel">
        <input type="text" name="channel_name" class="form-control" placeholder="{{__('invoice::dashboard.invoices.form.channel_name_placeholder')}}">
    </div>
</div> --}}

@if(request()->route()->getName()=='dashboard.invoices.edit')
<div class="form-group">
    <label for="" class="form-label">{{__('invoice::dashboard.invoices.datatable.status')}}</label>
    <select name="payment_status" id="" class="select2" readonly disabled>
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

@include('invoice::dashboard.invoices.partials.sharing_tools')
