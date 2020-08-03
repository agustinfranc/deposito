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
                <div class="card-header">Nuevo Producto</div>

                <div class="card-body">

                    <form action="{{ route('stock.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                          <label for="code">Codigo</label>
                          <input type="number" class="form-control" id="code" name="code" aria-describedby="codigoHelp" required>
                          {{-- <small id="codigoHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                        </div>
                        <div class="form-group">
                            <label for="detail">Detalle</label>
                            <input type="text" class="form-control" id="detail" name="detail" required>
                        </div>
                        <div class="form-group">
                            <label for="rubro">Rubro</label>
                            <input type="text" class="form-control" id="rubro" name="rubro" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Precio</label>
                            <input type="number" step=".01" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Cantidad Inicial</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="0" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>

            </div>
        </div>
        <div class="d-flex flex-row-reverse mt-3">
            <a href="{{ route('stock.index') }}" class="btn btn-outline-primary">Volver</a>
        </div>
    </div>
</div>
@endsection

{{-- @push('scripts')
    <script src="{{ asset('js/create.js') }}" defer></script>
@endpush --}}