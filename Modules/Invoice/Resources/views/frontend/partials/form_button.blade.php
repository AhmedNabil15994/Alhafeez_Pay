<div class="margin-top-3">
    <form action="{{route('web.invoice.pay')}}" method="post" id="payment_form">
        @csrf
        <input type="hidden" name="number" value="{{$invoice->number}}">
        <input type="hidden" name="id" value="{{$invoice->id}}">
        <input type="hidden" name="token" value="{{request()->token}}">
        <button id="pay_button" class="btn btn-primary" type="submit"> {{$button_title ?? __('invoice::frontend.invoices.pay_button')}} </button>
    </form>
    <span class="incomeTicker" id="counter" style="display: none;"> {{__('invoice::frontend.invoices.try_again_in')}} <span id="incomeTicker" class="text-danger font-weight-bold">30</span> {{__('invoice::frontend.invoices.seconds')}} </span>
</div>

@section('scripts')
@parent
<script>
// Income Ticker Display (displaying time until next pay day)
@isset($counter)
$("#counter").show();
var incomeTicker = 30;
$("#pay_button").prop("disabled", true);
window.setInterval(function(){
 if (incomeTicker > 0)
    {
        incomeTicker--;
        document.getElementById("incomeTicker").innerHTML = incomeTicker ;
    } else {
        $("#pay_button").prop("disabled", false);
        $("#counter").remove();
    }
}, 1000);
@endisset

$("#payment_form").on("submit", function(e)
{
    $("#pay_button").html("{{__('invoice::frontend.invoices.loading')}}")
    $("#pay_button").prop("disabled", true)
})
</script>
@endsection
