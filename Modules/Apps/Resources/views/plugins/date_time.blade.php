@isset($date)
    @if( $date instanceof \Illuminate\Support\Carbon )
        {{\Carbon\Carbon::parse($date)->format('Y-m-d')}}
        @isset($br)
            <br />
        @endisset
        <span class="text-info">{{\Carbon\Carbon::parse($date)->format('H:i:s')}}</span>
    @else
        @if(is_int($date))
            {{date('Y-m-d', $date)}}
            @isset($br)
            <br />
            <span class="text-info">{{date('H:i:s', $date)}}</span>
        @endisset
        @else
            {{$date}}
        @endif
    @endif
@endisset
