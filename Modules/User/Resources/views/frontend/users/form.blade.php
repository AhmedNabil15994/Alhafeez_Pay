
{!! field()->text('name', __('user::dashboard.users.form.name'), $model->name )!!}
<input type="hidden" name="phone_code" value="965" />
{!! field()->text('mobile', __('user::dashboard.users.form.mobile'), $model->mobile )!!}
{!! field()->email('email', __('user::dashboard.users.form.email'), $model->email  , ["autocomplete"=> "emm"])!!}
{!! field()->text('id_number', __('user::dashboard.users.form.id_number'), $model->id_number ?? request()->id_number  , ["autocomplete"=> "emm"])!!}
{!! field()->select('nationality_id', __('user::dashboard.users.form.nationality_id'),$list_countries->pluck('nationality','id')->toArray()) !!}
{!! field()->select('city_id', __('user::dashboard.users.form.city_id'),$list_cities->pluck('title','id')->toArray()) !!}
{!! field()->select('state_id', __('user::dashboard.users.form.state_id'),$list_states->pluck('title','id')->toArray()) !!}
@if($model && $model->trashed())
    {!! field()->checkBox('trash_restore',  __('apps::dashboard.datatable.form.restore') ) !!}
@endif

@push("scripts")
    <script>
        $(document).ready(function() {
                $('#email:not([value]').each( function() {
                        $(this).attr('readonly', 'true').attr('onClick', "this.removeAttribute('readonly');");
                });
        });
    </script>
@endpush
