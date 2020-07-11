@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Inicio</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a class="btn btn-primary" href=" {{ route('stock.index') }}" role="button">Ver Stock</a>
                    <a class="btn btn-primary" href="/orders" role="button">Ver Pedidos</a>

                    @if (auth()->user()->administrator)
                        <a class="btn btn-primary" href="/current-account" role="button">Ver Cuenta Corriente</a>
                    @else
                        <a class="btn btn-primary" href=" {{ route('carrito.index') }}" role="button">Ver Carrito</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
