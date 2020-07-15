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
                        <a class="nav-link active" id="activos-tab" data-toggle="tab" href="#activos" role="tab" aria-controls="activos" aria-selected="true">Pedidos Activos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="finalizados-tab" data-toggle="tab" href="#finalizados" role="tab" aria-controls="finalizados" aria-selected="false">Pedidos Finalizados</a>
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

                            <table class="table my-3">
                                <thead>
                                    <tr>
                                    <th scope="col">Pedido - Id</th>
                                    @if (auth()->user()->administrator)
                                        <th scope="col">Cliente</th>
                                    @endif
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Forma Pago</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Creado</th>
                                    <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $item)
                                        @if ($item->status_id < 6)
                                            <tr>
                                                <th scope="row"><span><a href="{{ route('orders.show', $item->id) }}">#{{ $item->id }}</a></span></th>
                                                @if (auth()->user()->administrator)
                                                    <td><span>{{ $item->email }}</span></td>
                                                @endif
                                                <td><span>{{ $item->shipping_date }}</span></td>
                                                <td><span>{{ $item->pay_form_name }}</span></td>
                                                <td><span>${{ $item->total }}</span></td>
                                                <td><span>{{ $item->created_at }}</span></td>
                                                <td>
                                                    <span>
                                                        {{-- @if (auth()->user()->administrator && $item->status_id < 3)
                                                            <a href="{{ route('orders.edit', $item->id) }}" class="btn disabled mr-2"><i class="material-icons">edit</i></a>
                                                        @endif --}}

                                                        <div style="display: inline-block;" class="dropdown">
                                                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">                                                </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                                <a class="dropdown-item" href="{{ route('orders.show', $item->id) }}"><i class="material-icons">remove_red_eye</i>Ver detalle</a>

                                                                @if (auth()->user()->administrator)
                                                                    @if ($item->status_id == 1)
                                                                        <a class="dropdown-item" href="orders/{{$item->id}}/state/2" ><i class="material-icons">check</i>Aprobar pedido</a>
                                                                        <a class="dropdown-item" href="orders/{{$item->id}}/state/7" ><i class="material-icons">cancel</i>Cancelar pedido</a>
                                                                    @elseif ($item->status_id == 2)
                                                                        <a class="dropdown-item" href="orders/{{$item->id}}/state/3" ><i class="material-icons">receipt</i>Facturar pedido</a>
                                                                        <a class="dropdown-item" href="orders/{{$item->id}}/state/7" ><i class="material-icons">cancel</i>Cancelar pedido</a>
                                                                    @elseif ($item->status_id == 3)
                                                                        <a class="dropdown-item" href="orders/{{$item->id}}/state/4" ><i class="material-icons">receipt</i>Marcar pedido como cobrado</a>
                                                                    @elseif ($item->status_id == 4)
                                                                        <a class="dropdown-item" href="orders/{{$item->id}}/state/5" ><i class="material-icons">receipt</i>Enviar pedido</a>
                                                                    @elseif ($item->status_id == 5)
                                                                        <a class="dropdown-item" href="orders/{{$item->id}}/state/6" ><i class="material-icons">receipt</i>Marcar pedido como recibido</a>
                                                                    @else

                                                                    @endif
                                                                @elseif ($item->status_id == 1)
                                                                    <a class="dropdown-item" href="orders/{{$item->id}}/state/7" ><i class="material-icons">cancel</i>Cancelar pedido</a>
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
                                        @endif
                                    @endforeach

                                </tbody>
                            </table>

                        </div>

                        <div class="tab-pane fade active" id="finalizados" role="tabpanel" aria-labelledby="finalizados-tab">

                            <div class="d-flex align-items-end flex-column bd-highlight mb-3">
                                @if (!auth()->user()->administrator)
                                    <a name="todos" id="todos" class="btn btn-primary mr-1" href="{{ route('stock.index') }}" role="button">Nuevo</a>
                                @endif
                            </div>

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
                                        @if ($item->status_id == 6)
                                            <tr>
                                                <th scope="row"><span><a href="{{ route('orders.show', $item->id) }}">#{{ $item->id }}</a></span></th>
                                                <td><span>{{ $item->email }}</span></td>
                                                <td><span>{{ $item->created_at }}</span></td>
                                                <td><span>${{ $item->total }}</span></td>
                                                <td>
                                                    <span>

                                                        <div style="display: inline-block;" class="dropdown">
                                                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">                                                </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                                <a class="dropdown-item" href="{{ route('orders.show', $item->id) }}"><i class="material-icons">remove_red_eye</i>Ver detalle</a>

                                                            </div>
                                                        </div>
                                                    </span>

                                                </td>

                                            </tr>
                                        @endif
                                    @endforeach

                                </tbody>
                            </table>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="d-flex flex-row-reverse mt-3">
        <a href="{{ route('home') }}" class="btn btn-outline-primary">Volver</a>
    </div>

</div>
@endsection

{{-- @push('scripts')
    <script src="{{ asset('js/stock.js') }}" defer></script>
@endpush --}}