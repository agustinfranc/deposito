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
                <div class="card-header">Editar Usuario</div>

                <div class="card-body">

                    <form action="{{ route('users.update', $user->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                          <label for="name">Nombre</label>
                          <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" aria-describedby="nameHelp" required>
                          {{-- <small id="codigoHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                        </div>
                        <div class="form-group">
                            <label for="cuit">CUIT</label>
                            <input type="text" class="form-control" id="cuit" name="cuit" value="{{ $user->cuit }}" required>
                        </div>
                        <div class="form-group">
                            <label for="razon">Razon</label>
                            <input type="text" class="form-control" id="razon" name="razon" value="{{ $user->razon }}" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Dirección</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ $user->address }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>

            </div>
        </div>
        <div class="d-flex flex-row-reverse mt-3">
            <a href="{{ route('users.index') }}" class="btn btn-outline-primary">Volver</a>
        </div>
    </div>
</div>
@endsection