@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Catalogo</div>

                <div class="card-body">
                    <a name="" id="" class="btn btn-primary" href="/catalogo" role="button">Carniceria</a>
                    <a name="" id="" class="btn btn-primary" href="/stock" role="button">Verduleria</a>
                    <a name="" id="" class="btn btn-primary" href="/pedidos" role="button">Fiambreria</a>

                    <ul id="lista-productos" class="list-group mt-3">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                          Cras justo odio
                          <span class="badge badge-primary badge-pill">+</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                          Dapibus ac facilisis in
                          <span class="badge badge-primary badge-pill">+</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                          Morbi leo risus
                          <span class="badge badge-primary badge-pill">+</span>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/catalogo.js') }}" defer></script>
@endpush