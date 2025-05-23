<div class="portlet light portlet-fit bg-inverse ">
    <div class="portlet-title">
        <div class="caption">
            <div class="row">
                <div class="col-md-8">
            <i class="icon-user font-red"></i>
            <span class="caption-subject bold font-red uppercase"> {{$user->id_number}} </span>
            <br /><span class="caption-helper">{{$user->name}}</span>
                </div>
                <div class="col-md-4">
                    <a href="{{route('vendors.users.add_note', $user->id_number)}}" class="btn btn-sm btn-info"><i class="fa fa-plus"></i>{{ trans('user::frontend.add_note') }}</a>
                </div>
            </div>
        </div>
        <div class="actions">
            @include('apps::frontend.partials.civil_status')
        </div>
    </div>
    <div class="portlet-body">
        <div class="timeline  white-bg ">
            <!-- TIMELINE ITEM -->
            @forelse ($user->notes as $note)
                @include('apps::frontend.partials.note_timeline')
            @empty
                @include('apps::frontend.partials.no_records')
            @endforelse
            <!-- END TIMELINE ITEM -->
        </div>
    </div>
</div>
