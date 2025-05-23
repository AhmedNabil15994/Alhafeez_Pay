<div class="portlet-title">
    <div class="caption font-dark">
        <i class="icon-settings font-dark"></i>
        <span class="caption-subject bold uppercase">
            {{__('invoice::dashboard.invoices.index.transactions')}}
        </span>
    </div>
</div>
<div style="height: 25px"></div>
{{-- DATATABLE CONTENT --}}
<div class="portlet-body">
    <table class="table table-striped table-bordered table-hover" id="dataTable" style="width: 100%">
        <thead>
            <tr>
                <th>
                    <a href="javascript:;" onclick="CheckAll()">
                        {{__('apps::dashboard.buttons.select_all')}}
                    </a>
                </th>
                <th>#</th>
                {{-- <th>{{__('invoice::dashboard.invoices.datatable.number')}}</th>
                <th>{{__('invoice::dashboard.invoices.datatable.client_name')}}</th>
                <th>{{__('invoice::dashboard.invoices.datatable.client_phone')}}</th> --}}
                <th>{{__('invoice::dashboard.invoices.datatable.transaction_key')}}</th>
                <th>{{__('invoice::dashboard.invoices.datatable.transaction_id')}}</th>
                <th>{{__('invoice::dashboard.invoices.datatable.amount')}} <sub>{{__('apps::dashboard.kwd')}}</sub></th>
                <th>{{__('invoice::dashboard.invoices.datatable.invoice_amount')}} <sub>{{__('apps::dashboard.kwd')}}</sub></th>
                <th>{{__('invoice::dashboard.invoices.datatable.status')}}</th>
                <th>{{__('invoice::dashboard.invoices.datatable.updated_at')}}</th>
                <th>{{__('invoice::dashboard.invoices.datatable.created_at')}}</th>
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
              url   : "{{ url(route('dashboard.invoices.transactions.datatable', ['status' => request()->status, 'invoice_id' => request()->id])) }}",
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
        //   responsive: !0,
          order     : [[ 1 , "desc" ]],
          columns: [
            {data: 'id' 		 	        , className: 'dt-center'},
      		{data: 'id' 		 	        , className: 'dt-center'},
      		// {data: 'invoice_number' 		 	        , className: 'dt-center'},
      		// {data: 'client_name' 		 	        , className: 'dt-center'},
      		// {data: 'client_phone' 		 	        , className: 'dt-center'},
            {data: 'transaction_key' 		 	        , className: 'dt-center'},
            {data: 'ref_id' 		 	        , className: 'dt-center'},
      		{data: 'amount' 		 ,orderable: false	        , className: 'dt-center'},
      		{data: 'invoice_amount' ,orderable: false		 	        , className: 'dt-center'},
            { data: "status" ,orderable: false , width: "1%",
              render: function(data, type, row){
                if( data=='complete' )
                {
                    return "<span class='label label-success'>{{__('invoice::dashboard.invoices.statuses.complete')}}</span>";
                } else if( data=='incomplete' ){
                    return "<span class='label label-danger'>{{__('invoice::dashboard.invoices.statuses.incomplete')}}</span>";
                } else if( data=='pending' ){
                    return "<span class='label label-warning'>{{__('invoice::dashboard.invoices.statuses.pending')}}</span>";
                }

              }
            },
            {data: 'updated_at' 		  , className: 'dt-center'},
            {data: 'created_at' 		  , className: 'dt-center'},
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
              title: '{{__('invoice::dashboard.invoices.datatable.created_at')}}',
              className: 'dt-center',
              orderable: false,

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
