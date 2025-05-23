<div class="modal fade" id="quick_invoice" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('dashboard.invoices.store')}}" method="post" id="create-invoice">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">{{ __('apps::dashboard._layout.navbar.quick_invoice') }}</h4>
            </div>
            <div class="modal-body">
                @csrf
                @include('invoice::dashboard.invoices.form')
            </div>
            <div class="modal-footer" id="buttons">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{__('invoice::dashboard.invoices.form.close')}}</button>
                <button type="submit" class="btn green">{{__('invoice::dashboard.invoices.form.create')}}</button>
            </div>
        </form>
        </div>
    </div>
</div>


