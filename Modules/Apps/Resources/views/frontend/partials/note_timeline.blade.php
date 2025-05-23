<div class="timeline-item">
    <div class="timeline-badge">
        <img class="timeline-badge-userpic" src="{{url($user->image)}}" style="min-height:75px;"> </div>
    <div class="timeline-body">
        <div class="timeline-body-arrow"> </div>
        <div class="timeline-body-head">
            <div class="timeline-body-head-caption">
                <a href="javascript:;" class="timeline-body-title font-blue-madison">{{$note->vendor->name}}</a>
                <span class="timeline-body-time font-grey-cascade">@include('apps::plugins.date_time', ['date' => $note->created_at])</span>
            </div>
        </div>
        <div class="timeline-body-content @if(is_rtl()=='rtl') text-right @else text-left @endif">
            <span class="font-grey-cascade @if(is_rtl()=='rtl') text-left @else text-right @endif"> {{$note->note}} </span>
        </div>
    </div>
</div>
