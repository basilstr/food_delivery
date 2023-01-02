<div class="form-group @if(isset($model) && $model->isHiddenAttribute($attr)) d-none  @endif">
    <div class="row">
        @isset($model)
        <div class="col-3">
            <div class="text-left">
                <img class="profile-user-img img-fluid" src="{{ $model->$attr  }}">
            </div>
        </div>
        @endisset
        <div class="{{ empty($model) ? 'col-12' : 'col-9' }}">
            <label for="{{ $attr }}">{{ __($title) }}</label>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" name="{{ $attr }}" id="{{ $attr }}" @if(isset($model) && $model->isReadOnlyAttribute($attr)) disabled @endif>
                    <label class="custom-file-label" lang="ru" for="{{ $attr }}">{{ __('Вибрати') }}</label>
                </div>
            </div>
        </div>
    </div>
</div>
