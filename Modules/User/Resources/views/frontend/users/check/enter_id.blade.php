@extends('apps::frontend.layouts.app')
@section('title', __('user::frontend.check_id'))
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('vendors.home')) }}">{{ __('apps::dashboard.index.title') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{ url(route('vendors.users.index')) }}">
                        {{ __('apps::dashboard._layout.aside._tabs.clients') }}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{ __('apps::dashboard._layout.aside.add_clients') }}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row m-grid-col-center">
            <div class="col-md-3"></div>
            <div class="col-md-6 text-center">

                <h3>{{ __('user::frontend.check_id') }}</h3>
                <form action="{{route('vendors.users.go_check_id')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="id_number" class="form-control input-lg" value="{{old('id_number')}}" placeholder="{{ __('user::frontend.enter_civil_id_placeholder') }}">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-lg"><i class="fa fa-search"></i> {{ trans('user::frontend.check') }}</button>
                    </div>
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>

        <div class="row">

        </div>
    </div>
</div>
@stop
