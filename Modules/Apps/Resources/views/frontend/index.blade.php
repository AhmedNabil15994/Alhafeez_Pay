@extends('apps::frontend.layouts.app')
@section('title', __('apps::dashboard.index.title'))
@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ url(route('dashboard.home')) }}">
                            {{ __('apps::dashboard.index.title') }}
                        </a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-10">
                    <h1 class="page-title"> {{ __('apps::dashboard.index.welcome') }} ,
                        <small><b style="color:red">{{ Auth::guard('vendor')->user()->name }} </b></small>
                    </h1>
                </div>
                <div class="col-md-2 m-grid-col-end" style="padding-top: 16px;">
                    @include('apps::frontend.partials.subscriptions_details')
                </div>
            </div>

            <div class="row m-grid-col-center">
                <div class="col-md-3"></div>
                <div class="col-md-6 text-center">
                    <p>
                        <lord-icon
                            src="https://cdn.lordicon.com/msoeawqm.json"
                            trigger="loop"
                            colors="primary:#121331,secondary:#08a88a"
                            style="width:90px;height:90px">
                        </lord-icon>
                    </p>
                    <h3>{{ trans('apps::dashboard.index.search_box.search_for_clients') }}</h3>
                    <div class="form-group">
                        <input id="civil_id_input" pattern="[0-9]+" type="text" class="form-control input-lg" placeholder="{{ trans('apps::dashboard.index.search_box.search_for_clients_placehoder') }}">
                    </div>
                    <div id="autocomplete_results" style="display: none;">

                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </div>

@stop

@push('scripts')
<script>
function delaySearch(callback, ms) {
  var timer = 0;
  return function() {
    var context = this, args = arguments;
    clearTimeout(timer);
    timer = setTimeout(function () {
      callback.apply(context, args);
    }, ms || 0);
  };
}

function setInputFilter(textbox, inputFilter, errMsg) {
  ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop", "focusout"].forEach(function(event) {
    textbox.addEventListener(event, function(e) {
      if (inputFilter(this.value)) {
        // Accepted value
        if (["keydown","mousedown","focusout"].indexOf(e.type) >= 0){
          this.classList.remove("input-error");
          this.setCustomValidity("");
        }
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        // Rejected value - restore the previous one
        this.classList.add("input-error");
        this.setCustomValidity(errMsg);
        this.reportValidity();
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      } else {
        // Rejected value - nothing to restore
        this.value = "";
      }
    });
  });
}

setInputFilter(document.getElementById("civil_id_input"), function(value) {
  return /^-?\d*$/.test(value); }, "{{ trans('apps::dashboard.index.search_box.must_type_integer') }}");

$('#civil_id_input').keyup(delaySearch(function (e) {
    $("#autocomplete_results").show();
    $("#autocomplete_results").html("<strong>{{ trans('apps::dashboard.index.search_box.loading') }}...</strong>");
  $.post("{{route('vendors.ajax.autocomplet.civil')}}", {"s": this.value, "_token": "{{csrf_token()}}"}, function(data)
  {
    $("#autocomplete_results").html(data);
  });
}, 500));

@if(!is_null(request()->id_number))
    $("#civil_id_input").val("{{request()->id_number}}").trigger('keyup');
@endif
</script>
@endpush
