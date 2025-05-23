<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-share font-dark hide"></i>
            <span class="caption-subject font-dark bold uppercase">{{__('apps::dashboard.feed')}}</span>
        </div>
    </div>
    <div class="portlet-body">
        <div class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">
            <ul class="feeds">
                @forelse ($data['feeds'] as $feed)
                <li>
                    <a href="javascript:;">
                        <div class="col1">
                            <div class="cont">
                                <div class="cont-col1">
                                    <div class="label label-sm
                                        @if($feed->type=='info') label-info
                                        @elseif($feed->type=='success') label-success
                                        @elseif($feed->type=='failed') label-danger
                                        @else label-default
                                        @endif
                                    ">
                                        <i class="{{!strlen($feed->icon) > 0 ? $feed->icon : 'fa fa-bell-o'}}"></i>
                                    </div>
                                </div>
                                <div class="cont-col2">
                                    <div class="desc"> {{$feed->feed}} </div>
                                </div>
                            </div>
                        </div>
                        <div class="col2">
                            <div class="date"> {{$feed->created_at->diffForHumans()}} </div>
                        </div>
                    </a>
                </li>
                @empty

                @endforelse
            </ul>
        </div>
    </div>
</div>
