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

                <div class="card-body">

                </div>

            </div>
        </div>
    </div>

    <div class="d-flex flex-row-reverse mt-3">
        <a href="{{ route('home') }}" class="btn btn-outline-primary">Volver</a>
    </div>

</div>
@endsection