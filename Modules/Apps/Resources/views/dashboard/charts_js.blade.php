@section('scripts')
<script src="{{asset('admin/assets/global/plugins/morris/raphael-min.js')}}" type="text/javascript"></script>
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function () {
    new Morris.Line({
        element: "invoices_chart",
        data: {!! $data['charts'] !!},
        xkey: "day",
        ykeys: ["all_invoices", "paid", "unpaid"],
        labels: ["{{__('apps::dashboard.total_invoices')}}", "{{__('apps::dashboard.paid_invoices')}}", "{{__('apps::dashboard.unpaid_invoices')}}"],
        lineColors: ['#3695e3', '#1de068', '#bd4a42'],
    })
});


</script>
@endsection
