@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    <h2>Pedido #{{$pedido->id}}</h2>
                    <span class="badge badge-primary">{{$pedido->email}}</span>
                    {{-- <span class="badge badge-secondary">${{$pedido->total}}</span> --}}
                    <span class="badge badge-secondary">{{$pedido->created_at}}</span>

                    <div class="tab-content">

                        <div class="tab-pane fade show active" id="activos" role="tabpanel" aria-labelledby="activos-tab">
                            <ul id="lista-productos" class="list-group mt-3">
                                <li class="list-group-item d-flex justify-content-between align-items-center">{{$pedido->email}}</li>
                            </ul>
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