@extends('invoice::dashboard.invoices.print_master')
@section('title',__('invoice::dashboard.invoices.show.invoice') .' # '. $model->number)
@section('content')

@include('invoice::dashboard.invoices.single')

@stop
