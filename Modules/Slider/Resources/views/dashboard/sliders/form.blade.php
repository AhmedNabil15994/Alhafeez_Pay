
{!! field()->langNavTabs() !!}

<div class="tab-content">
    @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
        <div class="tab-pane fade in {{ ($code == locale()) ? 'active' : '' }}"
             id="first_{{$code}}">
            {!! field()->text('title['.$code.']',
            __('slider::dashboard.sliders.form.title').'-'.$code ,
             optional($model)->getTranslation('title',$code),
                  ['data-name' => 'title.'.$code]
             ) !!}

            {!! field()->textarea('description['.$code.']',
            __('ensaan::dashboard.studentLevels.form.description').'-'.$code ,
                    $model->getTranslation('description' , $code),
                ['data-name' => 'description.'.$code]
            ) !!}
           
        </div>
    @endforeach
</div>
{!! field()->select('type', __('slider::dashboard.sliders.form.type'), \Modules\Slider\Enum\SliderType::selectData() )!!}

{!! field()->text('value', __('slider::dashboard.sliders.form.link'), $model->value , ["class"=> "base-type url form-control"] )!!}


{!! field()->date('start_at', __('slider::dashboard.sliders.form.start_at') )!!}
{!! field()->date('end_at', __('slider::dashboard.sliders.form.end_at') )!!}

{!! field()->file('image', __('slider::dashboard.sliders.form.image'),$model->image ? url($model->image) : null )!!}
{!! field()->checkBox('status', __('slider::dashboard.sliders.form.status')) !!}
@if($model && $model->trashed())
    {!! field()->checkBox('trash_restore', __('apps::dashboard.datatable.form.restore')) !!}
@endif

@push('scripts')
<script>
    $(function(){
        var type = $("#type")
        var baseType = $(".base-type")
       

        type.on('change.select2', function (e) {
            hadnelType(type.val())
        });

        function hadnelType(value){
            baseType.parents(".form-group").hide().end().prop("disabled", true)
            if(value){  
                $(`.${value}`).parents(".form-group").show().end().prop("disabled", false)
            }
        }
        hadnelType(type.val())
    })
</script>
@endpush