@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    <h2>Pedido #{{$order->id}}</h2>
                    <span class="badge badge-primary">{{$order->email}}</span>
                    <span class="badge badge-primary">{{$order->shipping_date}}</span>
                    <span class="badge badge-secondary">${{$order->total}}</span>
                    <span class="badge badge-secondary">{{$order->created_at}}</span>
                    <span class="badge badge-success">{{$order->status}}</span>
                    <span class="badge badge-secondary">{{$order->note}}</span>

                    <div class="tab-content">

                        <div class="tab-pane fade show active" id="activos" role="tabpanel" aria-labelledby="activos-tab">

                            {{-- <ul id="lista-productos" class="list-group mt-3">
                                @foreach($detail as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>#{{ $item->code }}</strong>
                                    <span>{{ $item->detail }}</span>
                                    <span>{{ $item->quantity }}</span>
                                    <span>${{ $item->price }}</span>

                                    @if (auth()->user()->administrator)
                                        <div class="float-right">

                                            <a href="{{ route('orders.edit', $item->id) }}" class="btn btn-warning btn-sm mr-2 disabled"><i class="material-icons">edit</i></a>

                                            <form action="{{ route('orders.destroy', $item->id) }}" class="d-inline" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-danger btn-sm disabled" type="submit"><i class="material-icons">delete</i></button>
                                            </form>

                                        </div>
                                    @endif

                                </li>
                                @endforeach
                            </ul> --}}

                            <table class="table my-5">
                                <thead>
                                    <tr>
                                        <th scope="col">Codigo</th>
                                        <th scope="col">Detalle</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col">Total</th>
                                        @if (auth()->user()->administrator)
                                            <th scope="col">Acciones</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($detail as $item)
                                    <tr>
                                        <th scope="row">#{{ $item->code }}</th>
                                        <td>{{ $item->detail }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>${{ $item->price }}</td>

                                        @if (auth()->user()->administrator)
                                            <td>
                                                {{-- <div>
                                                    <a href="{{ route('orders.edit', $item->id) }}" class="btn text-warning disabled"><i class="material-icons">edit</i></a>

                                                    <form action="{{ route('orders.destroy', $item->id) }}" class="d-inline" method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button class="btn text-danger disabled" type="submit"><i class="material-icons">delete</i></button>
                                                    </form>
                                                </div> --}}
                                            </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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