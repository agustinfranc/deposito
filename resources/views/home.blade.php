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

                    {{-- <a name="" id="" class="btn btn-primary disabled" href="/catalogo" role="button">Ver Catalogo</a> --}}
                    <a name="" id="" class="btn btn-primary" href=" {{ route('stock.index') }}" role="button">Ver Stock</a>
                    <a name="" id="" class="btn btn-primary" href="/pedidos" role="button">Ver Pedidos</a>
                    {{-- <a name="" id="" class="btn btn-primary disabled" href="/pedidos" role="button">Nuevo Pedido</a> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
