@extends('apps::dashboard.layouts.app')
@section('title', __('apps::dashboard.index.title'))
@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ url(route('dashboard.home')) }}">
                            {{ __('apps::dashboard.index.title') }}
                        </a>
                    </li>
                </ul>
            </div>
            <h1 class="page-title"> {{ __('apps::dashboard.index.welcome') }} ,
                <small><b style="color:red">{{ Auth::user()->name }} </b></small>
            </h1>

            @can('show_statistics')
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat2 ">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-purple-sharp">
                                    <span data-counter="counterup" data-value="{{$data['sales']}}">0</span>
                                    <small class="font-green-sharp">{{__('apps::dashboard.kwd')}}</small>
                                </h3>
                                <small>{{__('apps::dashboard.sales')}}</small>
                            </div>
                            <div class="icon">
                                <i class="fa fa-dollar"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat2 ">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-blue-sharp">
                                    <span data-counter="counterup" data-value="{{$data['invoices']}}">0</span>
                                </h3>
                                <small>{{__('apps::dashboard.invoices')}}</small>
                            </div>
                            <div class="icon">
                                <i class="icon-pie-chart"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat2 ">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-green-sharp">
                                    <span data-counter="counterup" data-value="{{$data['transactions']['success']}}">0</span>
                                </h3>
                                <small>{{__('apps::dashboard.success_transactions')}}</small>
                            </div>
                            <div class="icon">
                                <i class="icon-like"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat2 ">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-red-haze">
                                    <span data-counter="counterup" data-value="{{$data['transactions']['failed']}}">0</span>
                                </h3>
                                <small>{{__('apps::dashboard.failed_transactions')}}</small>
                            </div>
                            <div class="icon">
                                <i class="icon-dislike"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endcan
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light portlet-fit bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class=" icon-layers font-green"></i>
                                <span class="caption-subject font-green bold uppercase">{{__('apps::dashboard.invoices_charts')}}</span>
                            </div>

                        </div>
                        <div class="portlet-body">
                            <div id="invoices_chart" style="height:500px;"></div>
                        </div>
                    </div>
                </div>
            </div>

            @can('show_invoices')
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    @isset($data['feeds'])
                        @if( !is_null($data['feeds']) && is_countable($data['feeds']) )
                            @include('apps::dashboard.feeds')
                        @endif
                    @endisset
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    @isset($data['latest_invoices'])
                        @if( !is_null($data['latest_invoices']) && is_countable($data['latest_invoices']) )
                            @include('apps::dashboard.latest_invoices')
                        @endif
                    @endisset
                </div>
            </div>
            @endcan
        </div>

    @include('apps::dashboard.charts_js')
@stop
