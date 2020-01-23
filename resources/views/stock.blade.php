@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Stock</div>

                <div class="card-body">

                    <div class="d-flex align-items-end flex-column bd-highlight mb-3">
                        <a name="todos" id="todos" class="btn btn-primary mr-1" href="{{ route('stock.create') }}" role="button">Nuevo</a>
                    </div>

                    <div id="rubros">
                        <a name="todos" id="todos" class="btn btn-outline-primary mr-1" href="#" onclick="pintarLista()" role="button">Todos</a>
                        {{-- Ejemplo --}}
                        {{-- <a name="" id="" class="btn btn-primary" href="/catalogo" role="button">Carniceria</a>
                        <a name="" id="" class="btn btn-primary" href="/stock" role="button">Verduleria</a> --}}
                    </div>

                    <ul id="lista-productos" class="list-group mt-3">
                        {{-- Ejemplo --}}
                        {{-- <li class="list-group-item d-flex justify-content-between align-items-center">
                          Cras justo odio
                          <span class="badge badge-primary badge-pill">14</span>
                        </li> --}}
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/stock.js') }}" defer></script>
@endpush