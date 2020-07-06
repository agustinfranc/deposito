@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    <h2>Pedido #{{$pedido->id}}</h2>
                    <span class="badge badge-primary">{{$pedido->email}}</span>
                    <span class="badge badge-secondary">${{$pedido->total}}</span>
                    <span class="badge badge-secondary">{{$pedido->created_at}}</span>

                    <div class="tab-content">

                        <div class="tab-pane fade show active" id="activos" role="tabpanel" aria-labelledby="activos-tab">

                            <ul id="lista-productos" class="list-group mt-3">
                                @foreach($detail as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>#{{ $item->code }}</strong>
                                    <span>{{ $item->detail }}</span>
                                    <span>{{ $item->quantity }}</span>
                                    <span>${{ $item->price }}</span>

                                    @if (auth()->user()->administrator)
                                        <div class="float-right">

                                            <a href="{{ route('pedidos.edit', $item->id) }}" class="btn btn-warning btn-sm mr-2 disabled"><i class="material-icons">edit</i></a>

                                            <form action="{{ route('pedidos.destroy', $item->id) }}" class="d-inline" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-danger btn-sm disabled" type="submit"><i class="material-icons">delete</i></button>
                                            </form>

                                        </div>
                                    @endif

                                </li>
                                @endforeach
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