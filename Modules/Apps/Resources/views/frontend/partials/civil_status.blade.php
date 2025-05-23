@if(!is_null($user->notes))
@php
    $civil = $user->notes()->orderBy('id', 'asc')->select('id', 'owner_id', 'status')->first();
    $owner = $civil->owner->name;

    if( !is_null($user->vendor_id) )
    {
        $owner = $user->vendor->name;
    }
@endphp
    @if( !is_null($civil->status) )
    <div>
        @if( $civil->status=='clean' )
            <span class='label label-success'>{{__('note::dashboard.notes.datatable.clean')}}</span>
        @else
            <span class='label label-danger'>{{__('note::dashboard.notes.datatable.blocked')}}</span>
        @endif
    </div>
    <div style="padding-top: 2px;">
        <small>{{__('note::dashboard.notes.search_box.by')}}: {{$owner}}</small>
    </div>
    @endif
@endif
