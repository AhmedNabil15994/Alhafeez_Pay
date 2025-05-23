@extends('apps::frontend.layouts.app')
@section('title', __('apps::dashboard._layout.aside.add_clients'))
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

        <div class="row">
                {!! Form::model($model,[
                    'url'=> route('vendors.users.store'),
                    'id'=>'form',
                    'role'=>'form',
                    'method'=>'POST',
                    'class'=>'form-horizontal form-row-seperated',
                    'files' => true ,
                    "autocomplete"=> "off"
                ])!!}

                <div class="col-md-12">

                    {{-- RIGHT SIDE --}}
                    <div class="col-md-3">
                        <div class="panel-group accordion scrollable" id="accordion2">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a class="accordion-toggle"></a></h4>
                                </div>
                                <div id="collapse_2_1" class="panel-collapse in">
                                    <div class="panel-body">
                                        <ul class="nav nav-pills nav-stacked">
                                            <li class="active">
                                                <a href="#user_form" data-toggle="tab">
                                                    {{ __('user::dashboard.users.form.general') }}
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="#user_notes" data-toggle="tab">
                                                    {{ __('user::dashboard.users.form.notes') }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- PAGE CONTENT --}}
                    <div class="col-md-9">
                        <div class="tab-content">

                            {{-- CREATE FORM --}}
                            <div class="tab-pane active fade in" id="user_form">
                                <div class="col-md-10">
                                    @include('user::frontend.users.form')
                                </div>
                            </div>
                            <div class="tab-pane fade in" id="user_notes">
                                <div class="col-md-10">
                                    @include('user::frontend.users.form_notes')
                                </div>
                            </div>
                            {{-- END CREATE FORM --}}

                        </div>
                    </div>

                    {{-- PAGE ACTION --}}
                    <div class="col-md-12">
                        <div class="form-actions">
                            @include('apps::dashboard.layouts._ajax-msg')
                            <div class="form-group">
                                <button type="submit" id="submit" class="btn btn-lg blue">
                                    {{__('apps::dashboard.buttons.add')}}
                                </button>
                                <a href="{{url(route('vendors.users.index')) }}" class="btn btn-lg red">
                                    {{__('apps::dashboard.buttons.back')}}
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            {!! Form::close()!!}
        </div>
    </div>
</div>
@stop
