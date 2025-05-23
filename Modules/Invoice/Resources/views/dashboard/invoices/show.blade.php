@extends('apps::dashboard.layouts.app')
@section('title', __('invoice::dashboard.invoices.index.title'))
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('dashboard.home')) }}">{{ __('apps::dashboard.index.title') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{route('dashboard.invoices.index')}}">{{__('invoice::dashboard.invoices.index.title')}}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('invoice::dashboard.invoices.datatable.number')}} #{{$model->number}}</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">

                    @can('show_invoices')
                    <div class="row">
                        <div class="col-md-9">
                            <div class="tabset">
                                <!-- Tab 1 -->
                                <input type="radio" name="tabset" id="tab1" aria-controls="invoice_details" checked>
                                <label for="tab1">{{__('invoice::dashboard.invoices.tabs.invoice_details')}}</label>
                                <!-- Tab 2 -->
                                <input type="radio" name="tabset" id="tab2" aria-controls="transactions">
                                <label for="tab2">{{__('invoice::dashboard.invoices.tabs.transactions')}}</label>
                                <!-- Tab 3 -->
                                <input type="radio" name="tabset" id="tab3" aria-controls="links">
                                <label for="tab3">{{__('invoice::dashboard.invoices.tabs.payment_links')}}</label>
                                <div class="tab-panels">
                                    <section id="invoice_details" class="tab-panel">
                                        @include('invoice::dashboard.invoices.single-show')
                                        <a href="{{ route("dashboard.invoices.show", ["id" => "$model->id", "action" => "print"]) }}" class="btn btn-primary"><i class="fa fa-print"></i></a>
                                  </section>
                                    <section id="transactions" class="tab-panel">
                                      @include('invoice::dashboard.invoices.transactions.index', ['model' => $model->transactions])
                                    </section>
                                    <section id="links" class="tab-panel">
                                        @include('invoice::dashboard.invoices.payment-link')
                                    </section>
                                  </div>

                                </div>
                        </div>
                    </div>
                    @endcan


                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
/*
 CSS for the main interaction
*/
@if(app()->getLocale()=="en")
.tabset > input[type="radio"] {
  position: absolute;
  left: -200vw;
}
@else
.tabset > input[type="radio"] {
  position: absolute;
  right: -200vw;
}
@endif

.tabset .tab-panel {
  display: none;
}

.tabset > input:first-child:checked ~ .tab-panels > .tab-panel:first-child,
.tabset > input:nth-child(3):checked ~ .tab-panels > .tab-panel:nth-child(2),
.tabset > input:nth-child(5):checked ~ .tab-panels > .tab-panel:nth-child(3),
.tabset > input:nth-child(7):checked ~ .tab-panels > .tab-panel:nth-child(4),
.tabset > input:nth-child(9):checked ~ .tab-panels > .tab-panel:nth-child(5),
.tabset > input:nth-child(11):checked ~ .tab-panels > .tab-panel:nth-child(6) {
  display: block;
}

/*
 Styling
*/

.tabset > label {
  position: relative;
  display: inline-block;
  padding: 15px 15px 25px;
  border: 1px solid transparent;
  border-bottom: 0;
  cursor: pointer;
  font-weight: 600;
}

.tabset > label::after {
  content: "";
  position: absolute;
  left: 15px;
  bottom: 10px;
  width: 22px;
  height: 4px;
  background: #8d8d8d;
}

input:focus-visible + label {
  outline: 2px solid rgba(0,102,204,1);
  border-radius: 3px;
}

.tabset > label:hover,
.tabset > input:focus + label,
.tabset > input:checked + label {
  color: #06c;
}

.tabset > label:hover::after,
.tabset > input:focus + label::after,
.tabset > input:checked + label::after {
  background: #06c;
}

.tabset > input:checked + label {
  border-color: #ccc;
  border-bottom: 1px solid #fff;
  margin-bottom: -1px;
}

.tab-panel {
  padding: 30px 0;
  border-top: 1px solid #ccc;
}


/* .tabset {
  max-width: 65em;
} */
</style>
@endsection
@section('scripts')



@stop
