@extends('layouts.app')

@section('content')
<div class="container">

    @if (session('mensaje'))
        <div class="alert alert-success" role="alert">
            <strong>{{ session('mensaje') }}</strong>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">

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