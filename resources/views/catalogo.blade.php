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
                <div class="card-header">Stock</div>

                <div class="card-body">

                    <div id="rubros">
                        <a name="todos" id="todos" class="btn btn-outline-primary mr-1" href="{{ route('catalogo.index') }}" role="button">Todos</a>
                        @foreach($rubros as $item)
                            {{-- Ejemplo --}}
                    <a name="" id="" class="btn btn-primary" href="/catalogo/rubro/{{ $item->rubro }}" role="button">{{ $item->rubro }}</a>
                        @endforeach
                    </div>

                    <ul id="lista-productos" class="list-group mt-3">
                        @foreach($stock as $item)
                            {{-- Ejemplo --}}
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $item->detalle }}

                                <div class="float-right">
                                    
                                    <a href="{{ route('stock.edit', $item->id) }}" class="btn btn-warning btn-sm mr-2"><i class="material-icons">remove</i></a>
                                    <span class="btn btn-outline-info mr-2">{{ $item->cantidad }}</span>
                                    <form action="{{ route('stock.destroy', $item->id) }}" class="d-inline" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger btn-sm" type="submit"><i class="material-icons">add</i></button>
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
    <script src="{{ asset('js/catalogo.js') }}" defer></script>
@endpush --}}