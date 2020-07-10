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
                <div class="card-header">Carrito</div>

                <div class="card-body">

                    <ul id="lista-productos" class="list-group mb-5">
                        @if ($carrito ?? '')
                            @foreach($carrito as $item)
                                @if ($item["quantity"] > 0)
                                    {{-- Ejemplo --}}
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        
                                        <span class="font-weight-bold">${{ $item["quantity"] * $item["price"] }}</span>
                                        <span>{{ $item["detail"] }}</span>

                                        <div class="float-right">

                                            <form action="{{ route('carrito.update', $item["id"]) }}" class="d-inline" method="POST">
                                                @method('PUT')
                                                @csrf
                                                <input type="hidden" name="accion" value="quitado">
                                                <button class="btn btn-warning btn-sm mr-2" type="submit"><i class="material-icons">remove</i></button>
                                            </form>
                                            <button class="btn btn-outline-secondary mr-2">{{ $item["quantity"] }}</button>
                                            <form action="{{ route('carrito.update', $item["id"]) }}" class="d-inline" method="POST">
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
                                    <label for="formapago">Forma de pago</label>
                                    <select class="form-control" name="formapago" id="formapago">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="nota">¿Algo para aclarar?</label>
                                    <input type="text" class="form-control" name="nota" id="nota" placeholder="Nota">
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

</div>
@endsection