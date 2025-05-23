@php
    $note = \Modules\Note\Entities\Note::
    where('user_id', $model->id)
    ->where(function($q)
    {
        return $q->where('vendor_id', auth()->guard('vendor')->id())
        ->orWhere('vendor_id', auth()->guard('vendor')->user()->parent_id);
    })->first();
@endphp

<div class="form-group">
    <label for="" class="form-label">{{__('user::dashboard.users.form.notes')}} <span class="text-danger">*</span></label>
    <textarea name="note" id="" cols="30" rows="5" class="form-control" placeholder="{{__('user::frontend.add_note_placeholder')}}"></textarea>
</div>

<div class="form-group">
    <label class="form-label">{{__('user::dashboard.users.form.status')}} <span class="text-danger">*</span></label>
    <select name="status" id="" class="form-control select2">
        <option>{{__('user::frontend.select_status')}}</option>
        @foreach ([
            'clean' => __("note::dashboard.notes.datatable.clean"),
            'blocked' => __("note::dashboard.notes.datatable.blocked"),
        ] as $status => $tr)
            <option value="{{$status}}" @if($model->status==$status) selected @endif>{{$tr}}</option>
        @endforeach
    </select>
</div>
