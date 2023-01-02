<div class="form-group @if(isset($model) && $model->isHiddenAttribute($attr)) d-none  @endif">
    @if(!empty($title))
        <label class="control-label @if($required) required @endif" for="{{ $attr }}">{{ __($title) }}</label>
    @endif
    <select data-default="{{ !is_array($model->$attr) && isset($model->$attr) ? $model->$attr : 0 }}" {{ $multiple ? 'multiple' : '' }} name="{{ $id ? "ing[{$model->id}][$attr]" : $attr }}{{ $multiple ? '[]' : '' }}" class="custom-select rounded-0" id="{{ $id ? $attr.'-'.$model->id : $attr }}" @if(isset($model) && $model->isReadOnlyAttribute($attr)) disabled @endif>
        @if($nullable)
            <option
                {{ !empty($model) && empty($model->$attr)  ? ' selected' : ''}}
                value="{{ 0 }}">{{ __('не визначено') }}
            </option>
        @endif
        @foreach($items as $key => $item)
            <option
                @if($multiple)
                {{ !empty($model) && is_array($model->$attr) && in_array($key, $model->$attr) ? ' selected' : ''}}
                value="{{ $key }}">{{ $item }}
                @else
                    {{ isset($model) && $key == $model->$attr ?  ' selected' : ''}}
                    value="{{ $key }}">{{ $item }}
                @endif
            </option>
        @endforeach
    </select>
</div>
