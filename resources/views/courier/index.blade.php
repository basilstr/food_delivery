@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <h3>{{ __('Кур\'єри') }}</h3>
            <a href="{{ route('courier.create') }}" class="btn btn-success mb-3">{{ __('Створити кур\'єра') }}</a>
        </div>
    </div>

    <form action="{{ route('courier.index') }}" method="get">
        <x-filter :dataw="$data" :cities="$cities"  route="courier.index"/>
    </form>

    <div class="row">
        <div class="col-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">{{ __('Ім\'я') }}</th>
                    <th scope="col">{{ __('Місто') }}</th>
                    <th scope="col">{{ __('Дії')  }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($couriers as $courier)
                    <tr>
                        <th scope="row">{{$courier->id}}</th>
                        <td>{{$courier->name}}</td>
                        <td>{{$courier->getCityName()}}</td>
                        <td>
                            <a href="{{ route('courier.show', $courier->id) }}" class="btn btn-success btn-sm"><i class="far fa-eye"></i></a>
                            <a href="{{ route('courier.edit', $courier->id) }}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a>
                            @if($courier->status == App\Models\Courier::ACTIVE)
                                <button id="btn_active_{{ $courier->id }}" class="btn btn-danger btn-sm" data-status="{{ \App\Models\Courier::ACTIVE }}" title="{{ __('Деактивувати') }}" onclick="setCourierStatus({{ $courier->id }})"><i class="fas fa-user-minus"></i></button>
                            @else
                                <button id="btn_active_{{ $courier->id }}" class="btn btn-info btn-sm" data-status="{{ \App\Models\Courier::DISACTIVE }}" title="{{ __('Активувати') }}" onclick="setCourierStatus({{ $courier->id }})"><i class="fas fa-user-plus"></i></button>
                            @endif
                            <a href="{{ route('courier.delete', $courier->id) }}" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div>
                {{ $couriers->links() }}
            </div>
        </div>
    </div>
@endsection
