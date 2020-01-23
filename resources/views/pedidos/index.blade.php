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
                <div class="card-header">Pedidos</div>

                <div class="card-body">

                    <div class="d-flex align-items-end flex-column bd-highlight mb-3">
                        <a name="todos" id="todos" class="btn btn-primary mr-1" href="{{ route('pedidos.create') }}" role="button">Nuevo</a>
                    </div>

                    <ul id="lista-productos" class="list-group mt-3">
                        @foreach($pedidos as $item)
                            {{-- Ejemplo --}}
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $item->detalle }}

                                <div class="float-right">

                                    <a href="{{ route('pedidos.edit', $item) }}" class="btn btn-warning btn-sm mr-2"><i class="material-icons">edit</i></a>

                                    <form action="{{ route('pedidos.destroy', $item) }}" class="d-inline" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger btn-sm" type="submit"><i class="material-icons">delete</i></button>
                                    </form>

                                </div>
                                
                            </li>
                        @endforeach
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- @push('scripts')
    <script src="{{ asset('js/stock.js') }}" defer></script>
@endpush --}}