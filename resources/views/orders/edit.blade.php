@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    <h2>Pedido #{{$order->id}}</h2>
                    <span class="badge badge-primary">{{$order->email}}</span>
                    {{-- <span class="badge badge-secondary">${{$order->total}}</span> --}}
                    <span class="badge badge-secondary">{{$order->created_at}}</span>

                    <div class="tab-content">

                        <div class="tab-pane fade show active" id="activos" role="tabpanel" aria-labelledby="activos-tab">
                            <ul id="lista-productos" class="list-group mt-3">
                                <li class="list-group-item d-flex justify-content-between align-items-center">{{$order->email}}</li>
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