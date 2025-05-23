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
                    <a href="#">{{__('invoice::dashboard.invoices.index.title')}}</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">

                    @can('add_invoices')
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a class="btn sbold green open-invoice-modal" data-toggle="modal" href="#quick_invoice">
                                        <i class="fa fa-plus"></i> {{__('invoice::dashboard.invoices.form.create_invoice')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endcan

                    {{-- DATATABLE FILTER --}}
                    <div class="row">
                        <div class="portlet box grey-cascade">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-gift"></i>
                                    {{__('apps::dashboard.datatable.search')}}
                                </div>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                @include('invoice::dashboard.invoices.partials.filter')
                            </div>
                        </div>
                    </div>
                    {{-- END DATATABLE FILTER --}}

                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase">
                                {{__('invoice::dashboard.invoices.index.title')}}
                            </span>
                        </div>
                    </div>

                    {{-- DATATABLE CONTENT --}}
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="dataTable">
                            <thead>
                                <tr>
                                    <th>
                                        <a href="javascript:;" onclick="CheckAll()">
                                            {{__('apps::dashboard.buttons.select_all')}}
                                        </a>
                                    </th>
                                    <th>#</th>
                                    <th>{{__('invoice::dashboard.invoices.datatable.number')}}</th>
                                    <th>{{__('invoice::dashboard.invoices.datatable.reference_no')}}</th>
                                    <th>{{__('invoice::dashboard.invoices.datatable.client_name')}}</th>
                                    <th>{{__('invoice::dashboard.invoices.datatable.client_phone')}}</th>
                                    <th >{{__('invoice::dashboard.invoices.datatable.amount')}} <sub>{{__('apps::dashboard.kwd')}}</sub></th>
                                    <th>{{__('invoice::dashboard.invoices.datatable.note')}}</th>
                                    {{-- <th>{{__('invoice::dashboard.invoices.datatable.channel')}}</th> --}}
                                    <th>{{__('invoice::dashboard.invoices.datatable.payment_status')}}</th>
                                    <th>{{__('invoice::dashboard.invoices.datatable.created_at')}}</th>
                                    <th>{{__('invoice::dashboard.invoices.datatable.options')}}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <button type="submit" id="deleteChecked" class="btn red btn-sm" onclick="deleteAllChecked('{{ url(route('dashboard.invoices.deletes')) }}')">
                                {{__('apps::dashboard.datatable.delete_all_btn')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')

  <script>
    var searchTerm = '';
    $('#agents').on('change', function (e) {
    var data = $.map( $(this).select2('data'), function( value ) {
      return value.id;
    });

    if (data.length > 0) {
      searchTerm = data.join('|');
    }

    $("#agents_hidden_filter").val(searchTerm);
    // table.column(5).search(searchTerm, true, false).draw();
  });

   function tableGenerate(data='') {

      var dataTable =
      $('#dataTable').DataTable({
          "createdRow": function( row, data, dataIndex ) {
             if ( data["deleted_at"] != null ) {
                $(row).addClass('danger');
             }
          },
          ajax : {
              url   : "{{ url(route('dashboard.invoices.datatable', ['status' => request()->status])) }}",
              type  : "GET",
              dataType: "json",
              data  : {
                  req : data,
              },
          },
          language: {
              url:"//cdn.datatables.net/plug-ins/1.10.16/i18n/{{ucfirst(LaravelLocalization::getCurrentLocaleName())}}.json"
          },
          stateSave: true,
          processing: true,
          serverSide: true,
        //   responsive: !0,
          order     : [[ 1 , "desc" ]],
          columns: [
            {data: 'id' 		 	        , className: 'dt-center'},
      		{data: 'id' 		 	        , className: 'dt-center'},
      		{data: 'number' 		 	        , className: 'dt-center'},
      		{data: 'reference_no' 		 	        , className: 'dt-center'},
      		{data: 'client_name' 		 	        , className: 'dt-center'},
      		{data: 'client_phone' 		 	        , className: 'dt-center'},
      		{data: 'amount' 		 	        , className: 'dt-center'},
      		{data: 'note' 		 	        , className: 'dt-center'},
      		// {data: 'channel' 		 	        , className: 'dt-center'},
            { data: "payment_status" ,orderable: false , width: "1%",
              render: function(data, type, row){
                if( data=='success' )
                {
                    return "<span class='label label-success'>{{__('invoice::dashboard.invoices.statuses.success')}}</span>";
                } else if( data=='failed' ){
                    return "<span class='label label-danger'>{{__('invoice::dashboard.invoices.statuses.failed')}}</span>";
                } else if( data=='pending' ){
                    return "<span class='label label-warning'>{{__('invoice::dashboard.invoices.statuses.pending')}}</span>";
                } else if( data=='expired' ){
                    return "<span class='label label-danger'>{{__('invoice::dashboard.invoices.statuses.expired')}}</span>";
                }

              }
            },
            {data: 'created_at' 		  , className: 'dt-center'},
            {data: 'id'},
      		],
          columnDefs: [
            {
      				targets: 0,
      				width: '40px',
      				className: 'dt-center',
      				orderable: false,
      				render: function(data, type, full, meta) {
      					return `<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                          <input type="checkbox" value="${data}" class="group-checkable" name="ids">
                          <span></span>
                        </label>
                      `;
      				},
      			},
            {
              targets: -1,
              width: '15%',
              title: '{{__('invoice::dashboard.invoices.datatable.options')}}',
              className: 'dt-center',
              orderable: false,
              render: function(data, type, full, meta) {

                        //View
                        var viewUrl = '{{ route("dashboard.invoices.show", ["id" => ":id"]) }}';
                        viewUrl = viewUrl.replace(':id', data);

                        //Print
                        var printUrl = '{{ route("dashboard.invoices.show", ["id" => ":id", "action" => "print"]) }}';
                        printUrl = printUrl.replace(':id', data);

                        // Edit
      					var editUrl = '{{ route("dashboard.invoices.edit", ":id") }}';
      					editUrl = editUrl.replace(':id', data);

      					// Delete
      					var deleteUrl = '{{ route("dashboard.invoices.destroy", ":id") }}';
      					deleteUrl = deleteUrl.replace(':id', data);

      					return `
                          <div class="btn-group" role="group" aria-label="Basic example">
                          @can('show_invoices')
      						<a href="`+viewUrl+`" class="btn btn-sm light" title="View Invoice">
      			              <small><i class="fa fa-eye"></i></small>
      			            </a>
      					@endcan
                          @can('show_invoices')
      						<a target=_blank href="`+printUrl+`" class="btn btn-sm light" title="Print">
      			              <small><i class="fa fa-print"></i></small>
      			            </a>
      					@endcan

                @can('edit_invoices')
      						<a href="`+editUrl+`" class="btn btn-sm blue" title="Edit">
      			              <small><i class="fa fa-edit"></i></small>
      			            </a>
      					@endcan

                @can('delete_invoices')
                @csrf
                  <a href="javascript:;" onclick="deleteRow('`+deleteUrl+`')" class="btn btn-sm red">
                    <small><i class="fa fa-trash"></i></small>
                  </a>
                @endcan
                </div>`;
              },
            },
          ],
          dom: 'Bfrtip',
          lengthMenu: [
              [ 10, 25, 50 , 100 , 500 ],
              [ '10', '25', '50', '100' , '500']
          ],
  				buttons:[
  					{
  						extend: "pageLength",
              className: "btn blue btn-outline",
              text: "{{__('apps::dashboard.datatable.pageLength')}}",
              exportOptions: {
                  stripHtml: true,
                  columns: ':visible',
                  columns: [ 1 , 2 , 3 , 4 , 5 , 6 , 7,8,9]
              }
  					},
  					{
  						extend: "print",
              className: "btn blue btn-outline" ,
              text: "{{__('apps::dashboard.datatable.print')}}",
                exportOptions: {
                    stripHtml : false,
                    columns: ':visible',
                    columns: [1,3,4,6,7,8,9]
                }
  					},
  					// {
  					// 		extend: "pdf",
                    //         className: "btn blue btn-outline" ,
                    //         text: "{{__('apps::dashboard.datatable.pdf')}}",
                    //         exportOptions: {
                    //             stripHtml : false,
                    //             columns: ':visible',
                    //             columns: [1,3,4,6,7,8,9]
                    //         }
  					// },
  					{
  							extend: "excel",
                className: "btn blue btn-outline " ,
                text: "{{__('apps::dashboard.datatable.excel')}}",
                exportOptions: {
                    stripHtml : false,
                    columns: ':visible',
                    columns: [1,3,4,6,7,8,9]
                }
  					},
  					{
  							extend: "colvis",
                className: "btn blue btn-outline",
                text: "{{__('apps::dashboard.datatable.colvis')}}",
                exportOptions: {
                    stripHtml : false,
                    columns: ':visible',
                    columns: [1,3,4,6,7,8,9]
                }
  					}
  				]
      });
  }

  jQuery(document).ready(function() {
  	tableGenerate();
  });
  </script>

@stop
