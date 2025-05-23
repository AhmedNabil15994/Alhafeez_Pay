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
        <div class="portlet light bordered">
            <div class="row m-grid-col-center">
                <div class="col-md-3"></div>
                <div class="col-md-6">

                    <div class="text-center">
                        <h3>{{ __('user::frontend.add_note') }}</h3>
                    </div>
                    <div class="@if(is_rtl()=='rtl') text-right @else text-left @endif bg-info" style="padding: 12px;">
                        <div class="caption">
                            <i class="icon-user font-red"></i>
                            <span class="caption-subject bold font-red uppercase"> {{$model->id_number}} </span>
                            <br /><span class="caption-helper">{{$model->name}}</span>
                        </div>
                    </div>
                    <div style="padding: 12px; border: solid 1px #ccc">
                        <form action="{{route('vendors.users.submit_note', $model->id_number)}}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{$model->id}}">
                            @include('user::frontend.users.form_notes')

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-save"></i> {{ trans('user::frontend.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>

        <div class="row">

        </div>
    </div>
</div>
@stop
