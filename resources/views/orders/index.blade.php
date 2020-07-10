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

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="activos-tab" data-toggle="tab" href="#activos" role="tab" aria-controls="activos" aria-selected="true">Pedidos activos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="finalizados-tab" data-toggle="tab" href="#finalizados" role="tab" aria-controls="finalizados" aria-selected="false">Pedidos finalizados</a>
                    </li>
                    </li>
                </ul>

                <div class="card-body">

                    <div class="tab-content" id="myTabContent">

                        <div class="tab-pane fade show active" id="activos" role="tabpanel" aria-labelledby="activos-tab">

                            <div class="d-flex align-items-end flex-column bd-highlight mb-3">
                                @if (!auth()->user()->administrator)
                                    <a name="todos" id="todos" class="btn btn-primary mr-1" href="{{ route('stock.index') }}" role="button">Nuevo</a>
                                @endif
                            </div>

                            {{-- <ul id="lista-productos" class="list-group mt-3">
                                @foreach($orders as $item)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <strong>#{{ $item->id }}</strong>
                                        <span>{{ $item->created_at }}</span>
                                        <span>${{ $item->total }}</span>

                                        <div class="float-right">
                                            <a href="{{ route('orders.show', $item->id) }}" class="mr-2"><i class="material-icons">more</i></a>
                                        </div>

                                        @if (auth()->user()->administrator)
                                            <div class="float-right">

                                                <a href="{{ route('orders.edit', $item->id) }}" class="btn btn-warning btn-sm mr-2"><i class="material-icons">edit</i></a>

                                                <form action="{{ route('orders.destroy', $item->id) }}" class="d-inline" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="btn btn-danger btn-sm" type="submit"><i class="material-icons">delete</i></button>
                                                </form>

                                            </div>
                                        @endif

                                    </li>
                                @endforeach
                            </ul> --}}

                            <table class="table my-3">
                                <thead>
                                    <tr>
                                    <th scope="col">Pedido - Id</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $item)
                                    <tr>
                                        <th scope="row"><span><a href="{{ route('orders.show', $item->id) }}">#{{ $item->id }}</a></span></th>
                                        <td><span>{{ $item->email }}</span></td>
                                        <td><span>{{ $item->created_at }}</span></td>
                                        <td><span>${{ $item->total }}</span></td>
                                        <td>
                                            <span>
                                                @if (auth()->user()->administrator)
                                                    <a href="{{ route('orders.edit', $item->id) }}" class="btn disabled mr-2"><i class="material-icons">edit</i></a>
                                                @endif

                                                <div style="display: inline-block;" class="dropdown">
                                                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">                                                </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                        <a class="dropdown-item" href="{{ route('orders.show', $item->id) }}"><i class="material-icons">remove_red_eye</i>Ver detalle</a>

                                                        @if (auth()->user()->administrator)
                                                            <a class="dropdown-item" href="#"><i class="material-icons">check</i>Aprobar pedido</a>
                                                        @endif

                                                        {{-- @if (auth()->user()->administrator)
                                                            <form action="{{ route('orders.destroy', $item->id) }}" class="d-inline" method="POST">
                                                                @method('DELETE')
                                                                @csrf
                                                                <button class="dropdown-item" type="submit">Eliminar<i style="font-size: 16px;" class="material-icons">delete</i></button>
                                                            </form>
                                                        @endif --}}

                                                    </div>
                                                </div>
                                            </span>

                                        </td>

                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>

                        </div>

                        <div class="tab-pane fade active" id="finalizados" role="tabpanel" aria-labelledby="finalizados-tab">
                            Pedidos Finalizados
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection

{{-- @push('scripts')
    <script src="{{ asset('js/stock.js') }}" defer></script>
@endpush --}}