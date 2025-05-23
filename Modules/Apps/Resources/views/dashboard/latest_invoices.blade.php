<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-share font-dark hide"></i>
            <span class="caption-subject font-dark bold uppercase">{{__('apps::dashboard.latest_invoices')}}</span>
        </div>
    </div>
    <div class="portlet-body">
        <div class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">
            <ul class="feeds">
                @forelse ($data['latest_invoices'] as $invoice)
                <li>
                    <a href="javascript:;">
                        <div class="col1">
                            <div class="cont">
                                <div class="cont-col1">
                                    <div class="label label-sm
                                        @if($invoice->status=='paid') label-success
                                        @elseif($invoice->status=='unpaid') label-danger
                                        @else label-default
                                        @endif
                                    ">
                                        <i class="
                                        @if($invoice->status=='paid') fa fa-check-circle
                                        @elseif($invoice->status=='unpaid') fa fa-close
                                        @else fa-dot-circle-o
                                        @endif
                                        "></i>
                                    </div>
                                </div>
                                <div class="cont-col2">
                                    <div class="desc"> {{__('invoice::dashboard.invoices.datatable.number')}} <u>{{$invoice->number}}</u> ({{number_format($invoice->amount, 2)}} <sub>{{__('apps::dashboard.kwd')}}</sub>) </div>
                                </div>
                            </div>
                        </div>
                        <div class="col2">
                            <div class="date"> {{$invoice->created_at->diffForHumans()}} </div>
                        </div>
                    </a>
                </li>
                @empty

                @endforelse
            </ul>
        </div>
    </div>
</div>
