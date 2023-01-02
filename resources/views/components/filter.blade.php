<div class="row pb-2">
    <div class="col-2">
        <label class="control-label" for="name">{{ __("Ім'я") }}</label>
        <input type="text" name="name"
               class="form-control"
               value="{{ $dataw['name'] ?? '' }}"
               placeholder="{{ __("Ім'я") }}">
    </div>
    @empty(Auth::user()->city_id)
        <div class="col-2">
            <label class="control-label" for="city_id">{{ __('Місто') }}</label>
            <select name="city_id" class="custom-select rounded-0">
                <option
                    {{ !isset($dataw['city_id'])  ? ' selected' : ''}}
                    value="0">{{ __('не визначено') }}
                </option>
                @foreach($cities as $key => $item)
                    <option
                        {{ isset($dataw['city_id']) && $key == $dataw['city_id'] ?  ' selected' : ''}}
                        value="{{ $key }}">{{ $item }}
                    </option>
                @endforeach
            </select>
        </div>
    @endempty
    @if($roles)
        <div class="col-2">
            <label class="control-label" for="role">{{ __('Роль') }}</label>
            <select name="role" class="custom-select rounded-0">
                <option
                    {{ !isset($dataw['role'])  ? ' selected' : ''}}
                    value="0">{{ __('не визначено') }}
                </option>
                @foreach($roles as $key => $item)
                    <option
                        {{ isset($dataw['role']) && $key == $dataw['role'] ?  ' selected' : ''}}
                        value="{{ $key }}">{{ $item }}
                    </option>
                @endforeach
            </select>
        </div>
    @endif
    @if($providers)
    <div class="col-2">
        <label for="provider_id">{{ __('Керує закладом') }}</label>
        <select name="provider_id" class="form-control select2bs4 select2-hidden-accessible"
                id="provider_id" style="width: 100%;">
            <option {{ empty($dataw['provider_id'])  ?  ' selected' : ''}} value="0">
                {{ __('немає') }}
            </option>
            @foreach($providers as $provider)
                <option
                    {{ isset($dataw['provider_id']) && $provider->id == $dataw['provider_id'] ?  ' selected' : ''}}
                    value="{{ $provider->id }}">{{ $provider->name }}
                </option>
            @endforeach
        </select>
    </div>
    @endif
    <div class="col-2">
        <button type="submit" class="btn btn-primary" style="margin-top: 31px;">{{ __('Пошук') }}</button>
        <a href="{{ route($route) }}" class="btn btn-info"
           style="margin-top: 31px;">{{ __('Очистити') }}</a>
    </div>
</div>
