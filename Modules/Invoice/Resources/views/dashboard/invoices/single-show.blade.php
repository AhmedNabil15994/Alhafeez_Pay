<div class="portlet-title">
    <div class="caption font-dark">
        <i class="icon-settings font-dark"></i>
        <span class="caption-subject bold uppercase">
            {{__('invoice::dashboard.invoices.tabs.invoice_details')}}
        </span>
    </div>
</div>
<div style="height: 25px"></div>
<table class="table table-sm">
    <tbody>
      <tr>
        <td>{{__('invoice::dashboard.invoices.datatable.number')}}</td>
        <td>{{$model->number}}</td>
      </tr>
      <tr>
        <td>{{__('invoice::dashboard.invoices.datatable.reference_no')}}</td>
        <td>{{!is_null($model->plugin) ? $model->plugin->reference_no : '--'}}</td>
      </tr>
      <tr>
        <td>{{__('invoice::dashboard.invoices.datatable.client_name')}}</td>
        <td>{{$model->user->name}}</td>
      </tr>
      <tr>
        <td>{{__('invoice::dashboard.invoices.datatable.client_phone')}}</td>
        <td>{{$model->user->mobile}}</td>
      </tr>
      <tr>
        <td>{{__('invoice::dashboard.invoices.datatable.amount')}} <sub>{{__('apps::dashboard.kwd')}}</sub></td>
        <td>{{$model->amount}}</td>
      </tr>
      <tr>
        <td>{{__('invoice::dashboard.invoices.datatable.note')}}</td>
        <td>
            <blockquote>{{!is_null($model->plugin) ? $model->plugin->note : '--'}}</blockquote>
        </td>
      </tr>
      <tr>
        <td>{{__('invoice::dashboard.invoices.datatable.payment_status')}}</td>
        <td>
            @php
                $payment_status = !is_null($model->plugin) ? $model->plugin->payment_status : 'failed'
            @endphp
                @if( $payment_status=='success' )
                    <span class='label label-success'>{{__('invoice::dashboard.invoices.statuses.success')}}</span>
                @elseif( $payment_status=='failed' )
                    <span class='label label-danger'>{{__('invoice::dashboard.invoices.statuses.failed')}}</span>
                @elseif( $payment_status=='pending' )
                    <span class='label label-warning'>{{__('invoice::dashboard.invoices.statuses.pending')}}</span>
                @elseif( $payment_status=='expired' )
                    <span class='label label-danger'>{{__('invoice::dashboard.invoices.statuses.expired')}}</span>
                @endif
        </td>
        <tr>
            <td>{{__('invoice::dashboard.invoices.datatable.created_at')}}</td>
            <td>
                {{\Carbon\Carbon::parse($model->created_at)->format('Y-m-d')}}
                <span class="text-danger">{{\Carbon\Carbon::parse($model->created_at)->format('h:i:s a')}}</span>
            </td>
          </tr>
      </tr>
    </tbody>
  </table>
