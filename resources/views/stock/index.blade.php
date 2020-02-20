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

                    <div class="d-flex flex-row-reverse mb-3">
                        <a class="btn btn-outline-primary mr-1" href="exportar/stock" role="button">Exportar</a>
                        <a class="btn btn-primary mr-1" href="{{ route('stock.create') }}" role="button">Nuevo</a>
                    </div>

                    <div id="rubros" class="">
                        <a name="todos" id="todos" class="btn btn-outline-primary mr-1" href="{{ route('stock.index') }}" role="button">Todos</a>
                        @foreach($rubros as $item)
                            {{-- Ejemplo --}}
                    <a name="" id="" class="btn btn-primary" href="/stock/rubro/{{ $item->rubro }}" role="button">{{ $item->rubro }}</a>
                        @endforeach
                    </div>

                    <ul id="lista-productos" class="list-group my-5">
                        @foreach($stock as $item)
                            {{-- Ejemplo --}}
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                
                                @if ($item->cantidad == 0)
                                    <button class="btn btn-outline-danger mr-2">{{ $item->cantidad }}</button>
                                @else
                                    <button class="btn btn-outline-info mr-2">{{ $item->cantidad }}</button>
                                @endif
                                <span class="font-weight-bold">#{{ $item->codigo }}</span>
                                <span>{{ $item->detalle }}</span>
                                <span>{{ $item->rubro }}</span>

                                <div class="float-right">

                                    @if (auth()->user()->permiso)
                                        <a href="{{ route('stock.edit', $item->id) }}" class="btn btn-warning btn-sm mr-2"><i class="material-icons">edit</i></a>

                                        <form action="{{ route('stock.destroy', $item->id) }}" class="d-inline" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-danger btn-sm" type="submit"><i class="material-icons">delete</i></button>
                                        </form>
                                    @else
                                        <form action="{{ route('carrito.update', $item->id) }}" class="d-inline" method="POST">
                                            @method('PUT')
                                            @csrf
                                            <input type="hidden" name="accion" value="quitado">
                                            <button class="btn btn-warning btn-sm mr-2" type="submit"><i class="material-icons">remove</i></button>
                                        </form>
                                        <button class="btn btn-outline-secondary mr-2">{{ $item->carrito }}</button>
                                        <form action="{{ route('carrito.update', $item->id) }}" class="d-inline" method="POST">
                                            @method('PUT')
                                            @csrf
                                            <input type="hidden" name="accion" value="agregado">
                                            <button class="btn btn-warning btn-sm mr-2" type="submit"><i class="material-icons">add</i></button>
                                        </form>
                                    @endif

                                </div>
                                
                            </li>
                        @endforeach
                    </ul>

                    {{ $stock->links() }}
                </div>
            </div>
        </div>
    </div>

</div>
@if (!auth()->user()->permiso)
    <div class="fixed-bottom container pb-3">
    <button class="btn btn-primary btn-lg btn-block">Pedir ${{ $total }}</button>
    </div>
@endif
@endsection

{{-- @push('scripts')
    <script src="{{ asset('js/stock.js') }}" defer></script>
@endpush --}}