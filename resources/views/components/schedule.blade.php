<div class="row p-2">
    <div class="col-4">
        <label>{{ __('Початок та кінець') }}</label>
        <div class="input-group date mydate" id="{{ $id ? $attr.'-'.$model->id : $attr }}_start" data-target-input="nearest">
            <input type="text" name="{{ $id ? "ing[{$model->id}][$attr]" : $attr }}[start]"
                   @if(isset($model) && $model->isReadOnlyAttribute($attr)) readonly @endif
                   @if(isset($model)) value="{{ $model->$attr->toFormatArray()['start'] ?? '' }}" @endif
                   class="form-control datetimepicker-input"
                   placeholder="{{ __('робочий завжди') }}"
                   data-default="{{ isset($model) && isset($model->$attr->toFormatArray()['start']) ? $model->$attr->toFormatArray()['start']: '' }}"
                   data-target="#{{ $id ? $attr.'-'.$model->id : $attr }}_start"/>
            <div class="input-group-append" data-target="#{{ $id ? $attr.'-'.$model->id : $attr }}_start"
                 data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
        </div>
        <div class="input-group date mydate mt-3" id="{{ $id ? $attr.'-'.$model->id : $attr }}_finish" data-target-input="nearest">
            <input type="text" name="{{ $id ? "ing[{$model->id}][$attr]" : $attr }}[finish]"
                   @if(isset($model) && $model->isReadOnlyAttribute($attr)) readonly @endif
                   @if(isset($model)) value="{{ $model->$attr->toFormatArray()['finish'] ?? '' }}" @endif
                   class="form-control datetimepicker-input"
                   placeholder="{{ __('робочий завжди') }}"
                   data-default="{{ isset($model) && isset($model->$attr->toFormatArray()['finish']) ? $model->$attr->toFormatArray()['finish']: '' }}"
                   data-target="#{{ $id ? $attr.'-'.$model->id : $attr }}_finish"/>
            <div class="input-group-append" data-target="#{{ $id ? $attr.'-'.$model->id : $attr }}_finish"
                 data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
        </div>
    </div>
    <div class="col-8">
        <label for="work_schedule">{{ __('Час дії по дням тижня') }} <i class="text-info">(00:00 - 00:00 {{ __('вихідний') }})</i></label>
        <div class="row">
            @foreach($week as $key => $name)
                @if($key == 0)
                    <div class="col-6 input-group mb-3"></div>
                @else
                <div class="col-6 input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{ $name }}</span>
                    </div>
                    <input type="text"
                           @if(isset($model) && $model->isReadOnlyAttribute($attr)) readonly @endif
                           @if(isset($model))
                               name="{{ $id ? "ing[{$model->id}][$attr]" : $attr }}[{{ $key }}]"
                               class="form-control {{$model->$attr->toFormatArray()[$key] == '00:00-00:00' ? 'bg-warning' : '' }}"
                               value="{{ $model->$attr->toFormatArray()[$key] ?? '' }}"
                               placeholder="{{ __('робочий цілий день') }}"
                               data-default="{{ $model->$attr->toFormatArray()[$key] == '00:00-00:00' ? '00:00 - 00:00' : '' }}"
                               id="week_{{ $key }}{{ $id ? $attr.'-'.$model->id : $attr }}"
                           @else
                               name="{{ $id ? "ing[0][$attr]" : $attr }}[{{ $key }}]"
                               class="form-control"
                               value=""
                               placeholder="{{ __('робочий цілий день') }}"
                               data-default=""
                               id="week_{{ $key }}{{ $id ? $attr.'-0' : $attr }}"
                           @endif
                           data-inputmask='"mask": "99:99 - 99:99"'
                           data-save='' data-mask>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <div class="d-inline">
                                <input type="checkbox" value="1"
                                       class="week_check"
                                       @if(isset($model))
                                        data-id="{{ $key }}{{ $id ? $attr.'-'.$model->id : $attr }}"
                                            {{ $model->$attr->toFormatArray()[$key] == '00:00-00:00' ? 'checked' : '' }}
                                        data-default="{{ $model->$attr->toFormatArray()[$key] == '00:00-00:00' ? '1' : '' }}" >
                                        @else
                                            data-id="{{ $key }}{{ $id ? $attr.'-0' : $attr }}"
                                            data-default="" >
                                        @endif
                            </div></div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
