<div id="filter_data_table">
    <div class="panel-body">
        <form id="formFilter" class="horizontal-form">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                                {{__('apps::dashboard.datatable.form.date_range')}}
                            </label>
                            <div id="reportrange" class="btn default form-control">
                                <i class="fa fa-calendar"></i> &nbsp;
                                <span> </span>
                                <b class="fa fa-angle-down"></b>
                                <input type="hidden" name="from">
                                <input type="hidden" name="to">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                                {{__('apps::dashboard.datatable.form.soft_deleted')}}
                            </label>
                            <div class="mt-radio-list">
                                <label class="mt-radio">
                                    {{__('apps::dashboard.datatable.form.delete_only')}}
                                    <input type="radio" value="only" name="deleted" />
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    @if(is_null(request()->status))
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">
                                {{__('invoice::dashboard.invoices.datatable.payment_status')}}
                            </label>
                            <div class="mt-radio-list">
                                <label class="mt-radio">
                                    {{__('invoice::dashboard.invoices.statuses.success')}}
                                    <input type="radio" value="success" name="status" />
                                    <span></span>
                                </label>
                                <label class="mt-radio">
                                    {{__('invoice::dashboard.invoices.statuses.pending')}}
                                    <input type="radio" value="pending" name="status" />
                                    <span></span>
                                </label>
                                <label class="mt-radio">
                                    {{__('invoice::dashboard.invoices.statuses.failed')}}
                                    <input type="radio" value="failed" name="status" />
                                    <span></span>
                                </label>
                                <label class="mt-radio">
                                    {{__('invoice::dashboard.invoices.statuses.expired')}}
                                    <input type="radio" value="expired" name="status" />
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">
                                {{__('invoice::dashboard.invoices.datatable.number')}}
                            </label>
                            <input class="form-control" name="number" value="{{request()->number}}">
                        </div>
                        <div class="form-group">
                            <label class="control-label">
                                {{__('invoice::dashboard.invoices.datatable.reference_no')}}
                            </label>
                            <input class="form-control" name="reference_no" value="{{request()->reference_no}}">
                        </div>
                        <div class="form-group">
                            <label class="control-label">
                                {{__('invoice::dashboard.invoices.datatable.client_name')}}
                            </label>
                            <input class="form-control" name="name" value="{{request()->name}}">
                        </div>
                        <div class="form-group">
                            <label class="control-label">
                                {{__('invoice::dashboard.invoices.datatable.client_phone')}}
                            </label>
                            <input class="form-control" name="mobile" value="{{request()->mobile}}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" class="form-label">{{__('invoice::dashboard.invoices.datatable.or_select_users')}}</label>
                            <select name="user_ids[]" id="agents" class="form-control select2" multiple="multiple">
                                @forelse (\Modules\User\Entities\User::whereHas('roles.permissions', function ($query) {
                                    $query->where('name', 'dashboard_access');
                                })->cursor() as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @empty

                                @endforelse
                            </select>
                            <input type="hidden" name="agents_hidden_filter" id="agents_hidden_filter">
                        </div>
                    </div>

                </div>
            </div>
        </form>
        <div class="form-actions">
            <button class="btn btn-sm green btn-outline filter-submit margin-bottom" id="search">
                <i class="fa fa-search"></i>
                {{__('apps::dashboard.datatable.search')}}
            </button>
            <button class="btn btn-sm red btn-outline filter-cancel">
                <i class="fa fa-times"></i>
                {{__('apps::dashboard.datatable.reset')}}
            </button>
        </div>
    </div>
</div>
