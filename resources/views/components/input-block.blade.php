<div class="form-group @if(isset($model) && $model->isHiddenAttribute($attr)) d-none  @endif">
    @if(isset($model))
        <x-input :model="$model" :attr="$attr" :title="$title" :id="$id"/>
    @else
        <x-input :attr="$attr" :title="$title" :id="$id"/>
    @endif
</div>
