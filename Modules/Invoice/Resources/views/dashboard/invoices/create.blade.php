@extends('apps::dashboard.layouts.app')
@section('title', __('invoice::dashboard.invoices.form.create'))
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
                    <a href="{{ url(route('dashboard.invoices.index')) }}">
                        {{__('invoice::dashboard.invoices.index.title')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('invoice::dashboard.invoices.form.create')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
                <div class="col-md-12">

                    {{-- RIGHT SIDE --}}
                    <div class="col-md-3">

                    </div>

                    {{-- PAGE CONTENT --}}
                    <div class="col-md-6">
                        <div class="tab-content">

                            {{-- CREATE FORM --}}
                            <div class="tab-pane active fade in" id="global_setting">
                                <div class="col-md-12">

                                    <form action="{{route('dashboard.invoices.store')}}" method="post" id="create-invoice">
                                        @csrf
                                        @include('invoice::dashboard.invoices.form')
                                        @include('invoice::dashboard.invoices.partials.create-invoice-ajax')


                                        <div class="form-actions text-center">
                                            @include('apps::dashboard.layouts._ajax-msg')
                                            <div class="form-group" id="buttons">
                                                <button type="submit" id="submit" class="btn btn-lg blue">
                                                    {{__('apps::dashboard.buttons.add')}}
                                                </button>
                                                <a href="{{url(route('dashboard.invoices.index')) }}" class="btn btn-lg red">
                                                    {{__('apps::dashboard.buttons.back')}}
                                                </a>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                            {{-- END CREATE FORM --}}

                        </div>
                    </div>
                    <div class="col-md-3">

                    </div>

                    {{-- PAGE ACTION --}}
                    <div class="col-md-12">

                    </div>

                </div>
        </div>
    </div>
</div>
@stop
