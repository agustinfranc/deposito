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
                <div class="card-header">Nuevo Pedido</div>

                <div class="card-body">

                    <ul id="lista-productos" class="list-group mb-5">
                        @if ($carrito ?? '')
                            @foreach($carrito as $item)
                                @if ($item["quantity"] > 0)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">

                                        <span class="font-weight-bold">${{ $item["quantity"] * $item["price"] }}</span>
                                        <span>{{ $item["detail"] }}</span>

                                        <div class="float-right">
                                            <form action="{{ route('orders.updateCarrito', $item["id"]) }}" class="d-inline" method="POST">
                                                @method('PUT')
                                                @csrf
                                                <input type="hidden" name="accion" value="quitado">
                                                <button class="btn btn-warning btn-sm mr-2" type="submit"><i class="material-icons">remove</i></button>
                                            </form>
                                            <button class="btn btn-outline-secondary mr-2">{{ $item["quantity"] }}</button>
                                            <form action="{{ route('orders.updateCarrito', $item["id"]) }}" class="d-inline" method="POST">
                                                @method('PUT')
                                                @csrf
                                                <input type="hidden" name="accion" value="agregado">
                                                <button class="btn btn-warning btn-sm mr-2" type="submit"><i class="material-icons">add</i></button>
                                            </form>
                                        </div>

                                    </li>
                                @endif
                            @endforeach
                        @else
                            <div class="alert alert-success" role="alert">
                                <strong>Carrito vacio</strong>
                            </div>
                        @endif
                    </ul>

                    @if ($carrito ?? '')
                        <div class="container mt-5">

                            <div class="my-5">
                                <p>Subtotal ${{ $total ?? '' }}</p>
                                <strong>Total ${{ $total ?? '' }}</strong>
                            </div>

                            <h5>Detalles Entrega</h5>

                            <form action="{{ route('orders.store') }}" method="post">
                                @csrf

                                <input type="hidden" name="total" value="{{ $total }}">

                                <div class="form-group">
                                    <label for="shipping_date">Entrega</label>
                                    <input type="date" class="form-control" name="shipping_date">
                                </div>

                                <div class="form-group">
                                    <label for="pay_form_name">Forma de pago</label>
                                    <select class="form-control" name="pay_form_name">
                                        @foreach($pay_forms as $item)
                                            <option>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="note">¿Algo para aclarar?</label>
                                    <input type="text" class="form-control" name="note" placeholder="Nota">
                                </div>

                                <div class="form-group my-5">
                                    <button class="btn btn-primary btn-block" type="submit">Enviar pedido</button>
                                </div>
                            </form>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <div class="d-flex flex-row-reverse mt-3">
        <a href="{{ route('home') }}" class="btn btn-outline-primary">Volver</a>
    </div>

</div>
@endsection