@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <h3>{{ __('Клієнти') }}</h3>
            <a href="{{ route('client.create') }}" class="btn btn-success mb-3">{{ __('Створити клієнта') }}</a>
        </div>
    </div>

    <form action="{{ route('client.index') }}" method="get">
        <x-filter :dataw="$data" :cities="$cities"  route="client.index"/>
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
                @foreach($clients as $client)
                    <tr>
                        <th scope="row">{{$client->id}}</th>
                        <td>{{$client->name}}</td>
                        <td>{{$client->getCityName()}}</td>
                        <td>
                            <a href="{{ route('client.show', $client->id) }}" class="btn btn-success btn-sm"><i class="far fa-eye"></i></a>
                            <a href="{{ route('client.edit', $client->id) }}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a>
                            @if($client->status == App\Models\Client::ACTIVE)
                                <button id="btn_active_{{ $client->id }}" class="btn btn-danger btn-sm" data-status="{{ \App\Models\Client::ACTIVE }}" title="{{ __('Деактивувати') }}" onclick="setClientStatus({{ $client->id }})"><i class="fas fa-user-minus"></i></button>
                            @else
                                <button id="btn_active_{{ $client->id }}" class="btn btn-info btn-sm" data-status="{{ \App\Models\Client::DISACTIVE }}" title="{{ __('Активувати') }}" onclick="setClientStatus({{ $client->id }})"><i class="fas fa-user-plus"></i></button>
                            @endif
                            <a href="{{ route('client.delete', $client->id) }}" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div>
                {{ $clients->links() }}
            </div>
        </div>
    </div>
@endsection
