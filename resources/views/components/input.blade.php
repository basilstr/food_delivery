@if($id)
    <label class="control-label @if($required) required @endif" for="{{ $attr }}">{{ __($title) }}</label>
    <input type="text" name="{{ $id ? "ing[{$model->id}][$attr]" : $attr }}"
           class="form-control @error($attr, 'block_'.$model->id) is-invalid @enderror"
           @if(isset($model) && $model->isReadOnlyAttribute($attr)) readonly @endif
           id="{{ $id ? $attr.'-'.$model->id : $attr }}"
           value="{{ empty($model) ? '' : $model->$attr }}"
           data-default="{{ empty($model) ? '' : $model->$attr }}"
           placeholder="{{ __($title) }}">
    @error($attr, 'block_'.$model->id)
        <div id="{{ $attr }}Feedback" class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
@else
    <label class="control-label @if($required) required @endif" for="{{ $attr }}">{{ __($title) }}</label>
    <input type="text" name="{{ $attr }}"
           class="form-control @error($attr) is-invalid @enderror"
           @if(isset($model) && $model->isReadOnlyAttribute($attr)) readonly @endif
           id="{{ $attr }}"
           value="{{ empty($model) ? '' : $model->$attr }}"
           data-default="{{ empty($model) ? '' : $model->$attr }}"
           placeholder="{{ __($title) }}">
    @error($attr)
        <div id="{{ $attr }}Feedback" class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
@endif
