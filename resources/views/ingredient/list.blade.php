<ul class="list-group">
@foreach($ingredients as $ingredient)
    <li class="list-group-item">
        <div class="input-group">
            <div class="input-group-prepend pr-2">
                <span id="ingredient" class="input-group-text">
                  <input type="checkbox" value="{{$ingredient->id}}">
                </span>
            </div>
            <div class="col-auto mt-1">
                <img class="profile-user-img img-fluid" src="{{ $ingredient->photo }}">
            </div>
            <div class="col px-4">
                <div><b>{{ $ingredient->name }}</b></div>
                <div>{{ __('Ціна:') }} <b>{{ $ingredient->price }}</b> </div>
                <div>{{ __('Статус:') }} <b>{{ $ingredient->getStatusName() }}</b></div>
            </div>
        </div>
    </li>
@endforeach
</ul>
