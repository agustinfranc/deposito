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

                    @if (auth()->user()->administrator)
                        <div class="d-flex flex-row-reverse mb-3">
                            <a class="btn btn-outline-primary mr-1" href="exportar/stock" role="button">Exportar</a>
                            <a class="btn btn-primary mr-1" href="{{ route('stock.create') }}" role="button">Nuevo</a>
                        </div>
                    @endif

                    <div id="rubros" class="">
                        <a name="todos" id="todos" class="btn btn-outline-primary mr-1" href="{{ route('stock.index') }}" role="button">Todos</a>
                        @foreach($rubros as $item)
                            <a name="" id="" class="btn btn-primary" href="/stock/rubro/{{ $item->rubro }}" role="button">{{ $item->rubro }}</a>
                        @endforeach
                    </div>

                    <table class="table my-5">
                        <thead>
                            <tr>
                            <th scope="col">Stock</th>
                            <th scope="col">Codigo</th>
                            <th scope="col">Detalle</th>
                            <th scope="col">Rubro</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stock as $item)
                            <tr>
                                @if ($item->quantity == 0)
                                    <td class="text-danger">{{ $item->quantity }}</td>
                                @else
                                    <td class="text-primary">{{ $item->quantity }}</td>
                                @endif
                                <td class="font-weight-bold">#{{ $item->code }}</td>
                                <td>{{ $item->detail }}</td>
                                <td>{{ $item->rubro }}</td>
                                <td>${{ $item->price }}</td>

                                <td>
                                    <span>
                                        @if (auth()->user()->administrator)
                                            <a href="{{ route('stock.edit', $item->id) }}" class="btn text-warning btn-sm mr-2"><i class="material-icons">edit</i></a>
    
                                            <form action="{{ route('stock.destroy', $item->id) }}" class="d-inline" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn text-danger btn-sm disabled" type="submit"><i class="material-icons">delete</i></button>
                                            </form>
                                        @else
                                            @if ($item->quantity > 0 && $item->carrito > 0)
                                                <form action="{{ route('orders.updateCarrito', $item->id) }}" class="d-inline" method="POST">
                                                    @method('PUT')
                                                    @csrf
                                                    <input type="hidden" name="accion" value="quitado">
                                                    <button class="btn text-warning btn-sm mr-2" type="submit"><i class="material-icons">remove</i></button>
                                                </form>
                                            @else
                                                <button class="btn text-warning btn-sm mr-2 disabled" type="submit"><i class="material-icons">remove</i></button>
                                            @endif
                                            <a class="btn btn-outline-secondary mr-2">{{ $item->carrito }}</a>
                                            @if ($item->quantity > 0 && $item->quantity > $item->carrito)
                                                <form action="{{ route('orders.updateCarrito', $item->id) }}" class="d-inline" method="POST">
                                                    @method('PUT')
                                                    @csrf
                                                    <input type="hidden" name="accion" value="agregado">
                                                    <button class="btn text-warning btn-sm mr-2" type="submit"><i class="material-icons">add</i></button>
                                                </form>
                                            @else
                                                <button class="btn text-warning btn-sm mr-2 disabled" type="submit"><i class="material-icons">add</i></button>
                                            @endif
                                        @endif
                                    </span>

                                </td>

                            </tr>
                            @endforeach

                        </tbody>
                    </table>

                    {{ $stock->links() }}

                </div>
            </div>

        </div>
    </div>

    <div class="d-flex flex-row-reverse mt-3">
        <a href="{{ route('home') }}" class="btn btn-outline-primary">Volver</a>
    </div>

</div>
@if (!auth()->user()->administrator)
    <div class="fixed-bottom container pb-3">
    <a href="{{ route('orders.create') }}" class="btn btn-primary btn-lg btn-block">Pedir ${{ $total }}</a>
    </div>
@endif
@endsection

{{-- @push('scripts')
    <script src="{{ asset('js/stock.js') }}" defer></script>
@endpush --}}