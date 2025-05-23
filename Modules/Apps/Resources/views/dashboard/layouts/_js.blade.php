@if (is_rtl() == 'rtl')
  <script src="/admin/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-rtl.min.js" type="text/javascript"></script>
@else
  <script src="/admin/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
@endif
{{--<script src="{{ mix('js/app.js') }}"></script>--}}
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>

<div id="audioContinaer">

</div>

<script>
		$(document).ready(function()
		{
				$('#clickmewow').click(function()
				{
						$('#radio1003').attr('checked', 'checked');
				});
		})
</script>


<script type="text/javascript">
    $(document).ready(function() {
        $(".emojioneArea").emojioneArea();
    });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $(".emojioneArea").emojioneArea();
  });
</script>

<style>

  .emojionearea .emojionearea-picker.emojionearea-picker-position-top {
  	margin-bottom: -286px!important;
  	right: -14px;
  	z-index: 90000000000000;
  }

  .emojionearea .emojionearea-button.active+.emojionearea-picker-position-top {
      margin-top: 0px!important;
  }
</style>

<script>

  // DELETE ROW FROM DATATABLE
  function deleteRow(url)
  {
      var _token  = $('input[name=_token]').val();

      bootbox.confirm({
          message: '{{__('apps::dashboard.messages.delete')}}',
          buttons: {
              confirm: {
                  label: '{{__('apps::dashboard.buttons.yes')}}',
                  className: 'btn-success'
              },
              cancel: {
                  label: '{{__('apps::dashboard.buttons.no')}}',
                  className: 'btn-danger'
              }
          },

          callback: function (result) {
              if(result){

                  $.ajax({
                      method  : 'DELETE',
                      url     : url,
                      data    : {
                              _token  : _token
                          },
                      success: function(msg) {
                          toastr["success"](msg[1]);
                          $('#dataTable').DataTable().ajax.reload();
                      },
                      error: function( msg ) {
                          toastr["error"](msg[1]);
                          $('#dataTable').DataTable().ajax.reload();
                      }
                  });

              }
          }
      });
  }

  // DELETE ROW FROM DATATABLE
  function deleteAllChecked(url)
  {
      var someObj = {};
      someObj.fruitsGranted = [];

      $("input:checkbox").each(function(){
          var $this = $(this);

          if($this.is(":checked")){
              someObj.fruitsGranted.push($this.attr("value"));
          }
      });

      var ids = someObj.fruitsGranted;

      bootbox.confirm({
          message: '{{__('apps::dashboard.messages.delete_all')}}',
          buttons: {
              confirm: {
                  label: '{{__('apps::dashboard.buttons.yes')}}',
                  className: 'btn-success'
              },
              cancel: {
                  label: '{{__('apps::dashboard.buttons.no')}}',
                  className: 'btn-danger'
              }
          },

          callback: function (result) {
              if(result){

                  $.ajax({
                      type    : "GET",
                      url     : url,
                      data    : {
                              ids     : ids,
                          },
                      success: function(msg) {

                          if (msg[0] == true){
                              toastr["success"](msg[1]);
                              $('#dataTable').DataTable().ajax.reload();
                          }
                          else{
                              toastr["error"](msg[1]);
                          }

                      },
                      error: function( msg ) {
                          toastr["error"](msg[1]);
                          $('#dataTable').DataTable().ajax.reload();
                      }
                  });

              }
          }
      });
  }

  $(document).ready(function()
  {

    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        if (start.isValid()&& end.isValid()) {
            $('#reportrange span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="from"]').val(start.format('YYYY-MM-DD'));
            $('input[name="to"]').val(end.format('YYYY-MM-DD'));
        }else{
            $('#reportrange .form-control').val('Without Dates');
            $('input[name="from"]').val('');
            $('input[name="to"]').val('');
        }
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           '{{__('apps::dashboard.buttons.datapicker.today')}}'         : [moment(), moment()],
           '{{__('apps::dashboard.buttons.datapicker.yesterday')}}'     : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           '{{__('apps::dashboard.buttons.datapicker.7days')}}'         : [moment().subtract(6, 'days'), moment()],
           '{{__('apps::dashboard.buttons.datapicker.30days')}}'        : [moment().subtract(29, 'days'), moment()],
           '{{__('apps::dashboard.buttons.datapicker.month')}}'         : [moment().startOf('month'), moment().endOf('month')],
           '{{__('apps::dashboard.buttons.datapicker.last_month')}}'    : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
        },
          @if (is_rtl() == 'rtl')
          opens: 'left',
          @endif
          buttonClasses	 : ['btn'],
          applyClass	   : 'btn-primary',
          cancelClass	   : 'btn-danger',
          format 		     : 'YYYY-MM-DD',
          separator		   : 'to',
          locale: {
              applyLabel		    : '{{__('apps::dashboard.buttons.save')}}',
              cancelLabel		    : '{{__('apps::dashboard.buttons.cancel')}}',
              fromLabel			    : '{{__('apps::dashboard.buttons.from')}}',
              toLabel			      : '{{__('apps::dashboard.buttons.to')}}',
              customRangeLabel	: '{{__('apps::dashboard.buttons.custom')}}',
              firstDay: 1
          }
    }, cb);

    cb(start, end);

  });

</script>

<script>

  $('.delete').click(function() {
      $(this).closest('.form-group').find($('.' + $(this).data('input'))).val('');
      $(this).closest('.form-group').find($('.' + $(this).data('preview'))).html('');
  });

</script>

@if(config("app.allow_pusher")== "pusher")
<script>
    @if(config('app.debug'))
        Pusher.logToConsole = true;
    @endif

    var pusher = new Pusher("{{config('broadcasting.connections.pusher.key')}}", {
      cluster: "{{config('broadcasting.connections.pusher.options.cluster')}}"
    });

    var channel = pusher.subscribe('general');
    channel.bind('dashboard', function(data) {
        openActivity(data.data)
    });

    var audioContinaer = document.getElementById("audioContinaer")
    function playSound(autoPlay=true) {
        var x = document.createElement("AUDIO");
        x.setAttribute("src",  "{{ url('uploads/media/doorbell-5.mp3') }}" );
        if(autoPlay)
            x.setAttribute("autoplay", "");
        audioContinaer.innerHTML = "";
        audioContinaer.appendChild(x)
        autoPlay && x.play()
    }
    playSound(false)

    function openActivity(response) {
        // Show
        playSound()
        var showUrl = response.url ? response.url :  "";

        swal({
            title: response.title,
            icon: "success",
            buttons: true,
            dangerMode: true,
        })
            .then((willDone) => {
                if (willDone && showUrl) {
                    window.location.href = showUrl;
                }
            });
    }
</script>
@endif

<script>
    $("#channel").on("change", function()
    {
        $("#other_channel").hide();
        channel_key = $(this).val();
        if( channel_key=='pharmacy' || channel_key=='other' )
        {
            $("#other_channel").show();
        }
    })
    @isset($model)
    @if($model->plugin)
        @if(in_array(explode(":", $model->plugin->channel)[0], ['pharmacy', 'other']) )
        $("#other_channel").show();
        @endif
    @endif
    @endisset
    </script>

@stack('scripts')
