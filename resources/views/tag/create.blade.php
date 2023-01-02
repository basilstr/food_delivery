@extends('layouts.main')

@section('content')
    <form action="{{ route('tag.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
         <div class="col-lg-6 col-md-8 col-sm-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ __('Створення тег') }}</h3>
            </div>
            <div class="card-body">
                <x-input-block attr="name" title="Назва тегу"/>
                <x-input-block attr="description" title="Опис тегу"/>
                <x-select-block :items="$statuses" attr="status" title="Статус"/>
                <div class="form-group">
                    <label for="role">{{ __('Кореневий тег') }}</label>
                    <select name="parent_id" class="custom-select rounded-0" id="parent_id">
                        <option value="0">{{ __('Кореневий') }}</option>
                        @foreach($tags as $parentTag)
                            <option
                                {{ $parentTag->id == $tag->parent_id ?  ' selected' : ''}}
                                value="{{ $parentTag->id }}">
                                {{ $parentTag->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <x-photo attr="photo" title="Фото"/>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">{{ __('Створити') }}</button>
                </div>
            </div>
        </div>
        </div>
        </div>
    </form>
@endsection
