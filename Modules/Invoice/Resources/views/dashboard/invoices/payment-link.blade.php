<div class="portlet-title">
    <div class="caption font-dark">
        <i class="icon-settings font-dark"></i>
        <span class="caption-subject bold uppercase">
            {{__('invoice::dashboard.invoices.tabs.payment_links')}}
        </span>
    </div>
</div>
<div style="height: 25px"></div>
<table class="table table-sm">
    <tbody>
      <tr>
        <td>{{__('invoice::dashboard.invoices.datatable.original_link')}}</td>
        <td><a href="{{$model->link->original_link}}" target="_blank">{{$model->link->original_link}}</a></td>
      </tr>
      <tr>
        <td>{{__('invoice::dashboard.invoices.datatable.short_link')}}</td>
        <td>{{$model->link->short_link}}</td>
      </tr>
      <tr>
        <td>{{__('invoice::dashboard.invoices.datatable.status')}}</td>
        <td>
            @php
                $link_status = $model->link->status
            @endphp
                @if( $link_status=='valid' )
                    <span class='label label-success'>{{__('invoice::dashboard.invoices.statuses.valid')}}</span>
                @elseif( $link_status=='disabled' )
                    <span class='label label-danger'>{{__('invoice::dashboard.invoices.statuses.disabled')}}</span>
                @elseif( $link_status=='expired' )
                    <span class='label label-danger'>{{__('invoice::dashboard.invoices.statuses.expired')}}</span>
                @endif
        </td>
      </tr>
    </tbody>
  </table>
