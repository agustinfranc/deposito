@extends('layouts.app')

@section('content')
<div class="container">

    @if (session('mensaje'))
        <div class="alert alert-success" role="alert">
            <strong>{{ session('mensaje') }}</strong>
        </div>
    @endif

    <div class="row justify-content-center">

        <div class="col-md-12 mt-3">
            <div class="card">

                <div class="card-body">

                    <form action="{{ route('current-account.index') }}" method="get">

                        <div class="row mt-3">

                            <div class="col-12">
                                <h5>Filtros</h5>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="period-form">Periodo</label>
                                    <select class="form-control" id="period-form" name="period">
                                        @if ($request['period'])
                                            <option value="{{ $request['period'] }}">{{ $request['period'] }}</option>
                                        @endif
                                        <option>Ultima semana</option>
                                        <option>Ultimo mes</option>
                                        <option>Ultimo trimestre</option>
                                        <option>Ultimo semestre</option>
                                        <option>Ultimo año</option>
                                        <option>Más de un año</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email-form">Usuario</label>
                                    <select class="form-control" id="email-form" name="user_id">
                                        @if ($request['user_id'] && $user)
                                            <option value="{{ $request['user_id'] ?? '' }}">{{ $user['email'] ?? 'Todos' }}</option>
                                        @endif
                                        <option value="">Todos</option>
                                        @foreach ($users as $item)
                                            <option value="{{ $item->id }}">{{ $item->email }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group float-right">
                                    <button type="submit" class="btn btn-primary">Filtrar</button>
                                </div>
                            </div>

                        </div>
                    </form>

                    <table class="table my-3">
                        <thead>
                            <tr>
                            @if (auth()->user()->administrator)
                                <th scope="col">Cliente</th>
                                <th scope="col">Pedidos</th>
                                <th scope="col">Pedidos sin cobrar</th>
                                <th scope="col">Total</th>
                                <th scope="col">Total sin cobrar</th>
                            @else
                                <th scope="col">Pedidos</th>
                                <th scope="col">Pedidos sin pagar</th>
                                <th scope="col">Total</th>
                                <th scope="col">Total sin pagar</th>
                            @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $item)
                                <tr>
                                    @if (auth()->user()->administrator)
                                        <td><span>{{ $item->email }}</span></td>
                                    @endif
                                    <td><span>{{ $item->order_count }}</span></td>
                                    <td><span>{{ $item->pending_order_count }}</span></td>
                                    <td><span>${{ $item->order_total }}</span></td>
                                    <td><span>${{ $item->pending_order_total }}</span></td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>

    <div class="d-flex flex-row-reverse mt-3">
        <a href="{{ route('home') }}" class="btn btn-outline-primary">Volver</a>
    </div>

</div>
@endsection