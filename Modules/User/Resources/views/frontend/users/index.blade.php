@extends('apps::frontend.layouts.app')
@section('title', __('apps::dashboard._layout.aside._tabs.clients'))
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('vendors.home')) }}">{{ __('apps::frontend.index.title') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{ __('apps::dashboard._layout.aside._tabs.clients') }}</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">

                    @if( is_null(auth()->guard('vendor')->user()->parent_id) )
                    {{-- <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a href="{{ url(route('vendors.users.create')) }}" class="btn sbold green">
                                        <i class="fa fa-plus"></i> {{__('apps::frontend.buttons.add_new')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    @endif

                    {{-- DATATABLE FILTER --}}
                    <div class="row">
                        <div class="portlet box grey-cascade">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-gift"></i>
                                    {{__('apps::frontend.datatable.search')}}
                                </div>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div id="filter_data_table">
                                    <div class="panel-body">
                                        <form id="formFilter" class="horizontal-form">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                {{__('apps::dashboard.datatable.form.date_range')}}
                                                            </label>
                                                            <div id="reportrange" class="btn default form-control">
                                                                <i class="fa fa-calendar"></i> &nbsp;
                                                                <span> </span>
                                                                <b class="fa fa-angle-down"></b>
                                                                <input type="hidden" name="from">
                                                                <input type="hidden" name="to">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                {{__('apps::frontend.datatable.form.soft_deleted')}}
                                                            </label>
                                                            <div class="mt-radio-list">
                                                                <label class="mt-radio">
                                                                    {{__('apps::frontend.datatable.form.delete_only')}}
                                                                    <input type="radio" value="only" name="deleted" />
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>




                                                </div>
                                            </div>
                                        </form>
                                        <div class="form-actions">
                                            <button class="btn btn-sm green btn-outline filter-submit margin-bottom" id="search">
                                                <i class="fa fa-search"></i>
                                                {{__('apps::frontend.datatable.search')}}
                                            </button>
                                            <button class="btn btn-sm red btn-outline filter-cancel">
                                                <i class="fa fa-times"></i>
                                                {{__('apps::frontend.datatable.reset')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- END DATATABLE FILTER --}}

                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase">
                                {{ __('apps::dashboard._layout.aside._tabs.clients') }}
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
                                    <th  class="all">{{__('user::dashboard.users.datatable.name')}}</th>
                                    <th  class="all">{{__('user::dashboard.users.form.status')}}</th>
                                    <th  class="all">{{__('user::dashboard.users.datatable.id_number')}}</th>
                                    <th  class="all">{{__('user::dashboard.users.datatable.nationality')}}</th>
                                    <th  class="all">{{__('user::dashboard.users.datatable.city')}}</th>
                                    <th  class="all">{{__('user::dashboard.users.datatable.state')}}</th>
                                    <th>{{__('user::dashboard.users.datatable.email')}}</th>
                                    <th>{{__('user::dashboard.users.datatable.mobile')}}</th>
                                    <th>{{__('user::dashboard.users.datatable.created_at')}}</th>
                                    <th class="all">{{__('user::dashboard.users.datatable.options')}}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <button type="submit" id="deleteChecked" class="btn red btn-sm" onclick="deleteAllChecked('{{ url(route('vendors.users.deletes')) }}')">
                                {{__('apps::frontend.datatable.delete_all_btn')}}
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
   function tableGenerate(data='') {

      var dataTable =
      $('#dataTable').DataTable({
          "createdRow": function( row, data, dataIndex ) {
             if ( data["deleted_at"] != null ) {
                $(row).addClass('danger');
             }
          },
          ajax : {
              url   : "{{ url(route('vendors.users.datatable')) }}",
              type  : "GET",
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
          responsive: !0,
          order     : [[ 1 , "desc" ]],
          columns: [
            {data: 'id' 		 	        , className: 'dt-center'},
            {data: 'name' 			 , className: 'dt-center'},
            { data: "status" ,orderable: false , width: "1%",
                render: function(data, type, row){
                    if( data==0 )
                    {
                        return "<span class='label label-danger'>{{__('note::dashboard.notes.datatable.blocked')}}</span>";
                    } else {
                        return "<span class='label label-success'>{{__('note::dashboard.notes.datatable.clean')}}</span>";
                    }
                }
            },
            {data: 'id_number' 			 , className: 'dt-center'},
            {data: 'nationality' 			 , className: 'dt-center',
            render: (data, type, row) => {
                return data.title ?? '--'
            }},
            {data: 'city' 			 , className: 'dt-center',
            render: (data, type, row) => {
                return data.title ?? '--'
            }},
            {data: 'state' 			 , className: 'dt-center',
            render: (data, type, row) => {
                return data.title ?? '--'
            }},
            {data: 'email' 	          , className: 'dt-center'},
      			{data: 'mobile' 	        , className: 'dt-center'},
            {data: 'created_at' 		  , className: 'dt-center'},
            {data: 'id'},
      		],
          columnDefs: [
            {
      				targets: 0,
      				width: '30px',
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
              width: '13%',
              title: '{{__('user::dashboard.users.datatable.options')}}',
              className: 'dt-center',
              orderable: false,
              render: function(data, type, full, meta) {

                // Edit
      					var editUrl = '{{ route("vendors.users.edit", ":id") }}';
      					editUrl = editUrl.replace(':id', data);

      					// Delete
      					var deleteUrl = '{{ route("vendors.users.destroy", ":id") }}';
      					deleteUrl = deleteUrl.replace(':id', data);

      					return `
      						<a href="`+editUrl+`" class="btn btn-sm blue" title="Edit">
      			              <i class="fa fa-edit"></i>
      			            </a>

                @if(is_null(auth()->guard('vendor')->user()->parent_id))
                @csrf
                  <a href="javascript:;" onclick="deleteRow('`+deleteUrl+`')" class="btn btn-sm red">
                    <i class="fa fa-trash"></i>
                  </a>
                @endif`;
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
              text: "{{__('apps::frontend.datatable.pageLength')}}",
              exportOptions: {
                  stripHtml: true,
                  columns: ':visible',
                  columns: [ 1 , 2 , 3 , 4 , 5 , 6 , 7,8,9]
              }
  					},
  					{
  						extend: "print",
              className: "btn blue btn-outline" ,
              text: "{{__('apps::frontend.datatable.print')}}",
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
                text: "{{__('apps::frontend.datatable.excel')}}",
                exportOptions: {
                    stripHtml : false,
                    columns: ':visible',
                    columns: [1,3,4,6,7,8,9]
                }
  					},
  					{
  							extend: "colvis",
                className: "btn blue btn-outline",
                text: "{{__('apps::frontend.datatable.colvis')}}",
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
