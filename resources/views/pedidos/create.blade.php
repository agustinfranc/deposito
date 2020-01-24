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

                    <form action="{{ route('pedidos.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                          <label for="codigo">Codigo</label>
                          <input type="number" class="form-control" id="codigo" name="codigo" aria-describedby="codigoHelp" required>
                          {{-- <small id="codigoHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                        </div>
                        <div class="form-group">
                            <label for="detalle">Detalle</label>
                            <input type="text" class="form-control" id="detalle" name="detalle" required>
                        </div>
                        <div class="form-group">
                            <label for="rubro">Rubro</label>
                            <input type="text" class="form-control" id="rubro" name="rubro" required>
                        </div>
                        <div class="form-group">
                            <label for="precio">Precio</label>
                            <input type="number" class="form-control" id="precio" name="precio" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

            </div>
        </div>
    </div>
</div>
@endsection

{{-- @push('scripts')
    <script src="{{ asset('js/create.js') }}" defer></script>
@endpush --}}