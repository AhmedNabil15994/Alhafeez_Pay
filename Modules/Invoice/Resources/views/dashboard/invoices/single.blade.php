<div class="invoice-content-2 bordered">
    <div class="row invoice-head">
        <div class="col-md-7 col-xs-6">
            <div class="invoice-logo">
                @if( !is_null(setting('logo')) )
                    <img src="{{url(setting('logo'))}}" alt="" style="max-height:100px;" />
                @endif
                <h1 class="uppercase">{{__('invoice::dashboard.invoices.show.invoice')}} #{{$model->number}}</h1>
            </div>
        </div>
        <div class="col-md-5 col-xs-6">
            <div class="company-address">
                <span class="bold uppercase">{{setting('app_name', app()->getLocale())}}</span>
                <br/>
                <span class="bold">E</span> {{setting('contact_us', 'email')}}
                <br/>
                <span class="bold">W</span> {{config('app.url')}} </div>
        </div>
    </div>
    <div class="row invoice-cust-add">
        <div class="col-xs-3">
            <h2 class="invoice-title uppercase" style="font-size: 18px; font-weight:bold">{{__('invoice::dashboard.invoices.datatable.vendor')}}</h2>
            <p class="invoice-desc">{{$model->user->name ?? ''}}</p>
        </div>
        <div class="col-xs-3">
            <h2 class="invoice-title uppercase" style="font-size: 18px; font-weight:bold">{{__('invoice::dashboard.invoices.show.date')}}</h2>
            <p class="invoice-desc">{{\Carbon\Carbon::parse($model->created_at)->format('Y-m-d')}}</p>
        </div>
        <div class="col-xs-3">
            <h2 class="invoice-title uppercase" style="font-size: 18px; font-weight:bold">{{__('invoice::dashboard.invoices.show.email')}}</h2>
            <p class="invoice-desc inv-address">{{$model->user->email ?? ''}}</p>
        </div>
        <div class="col-xs-3">
            <h2 class="invoice-title uppercase" style="font-size: 18px; font-weight:bold">{{__('invoice::dashboard.invoices.show.mobile')}}</h2>
            <p class="invoice-desc inv-address">{{$model->user->mobile ?? ''}}</p>
        </div>
    </div>
    <br />
    <div class="row invoice-body">
        <div class="col-xs-12 table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="invoice-title uppercase">{{__('invoice::dashboard.invoices.show.description')}}</th>
                        <th class="invoice-title uppercase text-center">{{__('invoice::dashboard.invoices.datatable.amount')}}</th>
                        <th class="invoice-title uppercase text-center">{{__('invoice::dashboard.invoices.datatable.vat_amount')}}</th>
                        <th class="invoice-title uppercase text-center">{{__('invoice::dashboard.invoices.datatable.discount_amount')}}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <h3>
                                {{$model->plugin->note}}
                            </h3>
                            <small><strong>{{__('invoice::dashboard.invoices.datatable.reference_no')}}</strong>: {{$model->plugin->reference_no}}</small>
                        </td>
                        <td class="text-center sbold">{{ number_format($model->amount, 2)}} <sub>{{__('apps::dashboard.kwd')}}</sub></td>
                        <td class="text-center sbold">{{ number_format($model->vat_amount, 2)}} <sub>{{__('apps::dashboard.kwd')}}</sub></td>
                        <td class="text-center sbold">{{ number_format($model->discount_amount, 2)}} <sub>{{__('apps::dashboard.kwd')}}</sub></td>
                    </tr>
            </table>
        </div>
    </div>
    <div class="row invoice-subtotal">
        <div class="col-xs-6">
            <h2 class="invoice-title uppercase">{{__('invoice::dashboard.invoices.datatable.total')}}</h2>
            <p class="invoice-desc grand-total">{{ number_format($model->total, 2)}} <sub>{{__('apps::dashboard.kwd')}}</sub></p>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <a class="btn btn-lg green-haze hidden-print uppercase print-btn" onclick="javascript:window.print();">{{__('invoice::dashboard.invoices.show.print')}}</a>
        </div>
    </div>
</div>
