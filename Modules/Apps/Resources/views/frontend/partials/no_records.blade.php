<svg xmlns="http://www.w3.org/2000/svg" width="75" height="75" class="text-danger" viewBox="0 0 1024 1024"><path fill="currentColor" d="M512 0c283 0 512 229 512 512s-229 512-512 512S0 795 0 512S229 0 512 0zm0 961c247 0 448-202 448-449S759 64 512 64S64 265 64 512s201 449 448 449zm-35-417H288c-18 0-32-14-32-32s14-32 32-32h448c18 0 32 14 32 32s-14 32-32 32H477z"/></svg>
<h3>
    {{ trans('apps::dashboard.index.search_box.no_results') }}
</h3>
<div class="p-4">
    @if((int) request()->s > 0 && strlen(request()->s)===12 )
    <form action="{{route('vendors.users.go_check_id')}}" method="post">
        @csrf
        <input type="hidden" name="id_number" value="{{request()->s}}">

        <button type="submit" class="btn btn-sm btn-info"><i class="fa fa-plus"></i>{{ trans('apps::dashboard._layout.aside.add_clients') }}</button>
    </form>
    @endif
</div>
