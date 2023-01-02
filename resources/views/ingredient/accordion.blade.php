<input type="hidden" name="ing[{{ $ingredient->id }}][id]"
       value="{{ $ingredient->id }}">
<div class="card @if($errors->hasBag('block_'.$ingredient->id)) card-danger @else card-info @endif">
    <div class="card-header">
        <div class="row">
            <div class="col-11">
                <h4 class="card-title w-100">
                    <a class="d-block w-100" data-toggle="collapse"
                       href="#collapse{{ $ingredient->id }}">
                        <div class="row">
                            <div class="col-auto mr-auto">
                                <div class="text-center"><img class="profile-user-img"
                                                              src="{{ $ingredient->parentIngredient->photo }}"/></div>
                            </div>
                            <div class="col px-4">
                                <div><h4>{{ $ingredient->parentIngredient->name }}</h4></div>
                                <div>{{ __('Статус') }}: <i>{{ $ingredient->parentIngredient->getStatusName() }}</i></div>
                                <div>{{ $ingredient->parentIngredient->description }}</div>
                            </div>
                        </div>
                    </a>
                </h4>
            </div>
            <div class="col-1">
                <div class="text-right">
                    <a onclick="return confirm('{{ __('Продовжити видалення?') }}')" href="{{ route('ingredient.delete', $ingredient->id) }}" class="btn btn-danger "><i class="far fa-trash-alt"></i></a>
                </div>
                @if(Auth::id() == \App\Models\User::ADMIN_ID)
                    <div class="text-right mt-1">
                        <a href="{{ route('ingredient.history', $ingredient->id) }}" class="btn btn-info "><i class="fas fa-microscope"></i></a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div id="collapse{{ $ingredient->id }}" class="collapse" data-parent="#accordion">
        <div class="card-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-3">
                        <x-input :model="$ingredient" attr="weight"
                                 title="Вага інгредієнта" :id="true"/>
                    </div>
                    <div class="col-3">
                        <x-input :model="$ingredient" attr="price" title="Ціна"
                                 :id="true"/>
                    </div>
                    <div class="col-3">
                        <x-input :model="$ingredient" attr="price_package"
                                 title="Ціна пакування" :id="true"/>
                    </div>
                    <div class="col-3">
                        <x-input :model="$ingredient" attr="sort"
                                 title="Сортування" :id="true"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-3">
                        <x-input :model="$ingredient" attr="amount"
                                 title="Кількість" :id="true"/>
                    </div>
                    <div class="col-3">
                        <x-select :model="$ingredient"
                                  :items="$ingredient->getCanChangeList()"
                                  attr="can_change" title="Обов'язковість" :id="true"/>
                    </div>
                    <div class="col-3">
                        <x-select :model="$ingredient"
                                  :items="$ingredient->getTypeChangeList()"
                                  attr="type_change" title="По замовчуванню"
                                  :id="true"/>
                    </div>
                    <div class="col-3">
                        <x-select :model="$ingredient"
                                  :items="$ingredient->getListStatus()" attr="status"
                                  title="Статус" :id="true"/>
                    </div>
                </div>
            </div>

            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Графік активності інгредієнта') }}</h3>
                </div>
                <x-schedule :model="$ingredient" attr="work_schedule" :id="true"/>
                @error('work_schedule', 'block_'.$ingredient->id)
                <div class="alert alert-danger" role="alert">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="card card-success">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto mr-auto"><h3
                                class="card-title">{{ __('Акції') }}</h3></div>
                        <div class="col-auto">
                            <x-select :model="$ingredient"
                                      :items="$ingredient->getListStatus()"
                                      attr="promote_status" title="" :id="true"/>
                        </div>
                    </div>
                </div>
                <div class="p-2">
                    <x-input-block :model="$ingredient" attr="promote_description"
                                   title="Назва акції" :id="true"/>
                </div>
                <x-schedule :model="$ingredient" attr="promote_schedule" :id="true"/>

                @error('promote_schedule')
                <div class="alert alert-danger" role="alert">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
    </div>
</div>
