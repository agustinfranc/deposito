@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 mt-3">
            <div class="card">
                <div class="card-body">
                    
                    <table class="table my-3">
                        <thead>
                            <tr>
                            <th scope="col">Email</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">CUIT</th>
                            <th scope="col">Razon</th>
                            <th scope="col">Dirección</th>
                            <th scope="col">Creado</th>
                            <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $item)
                                <tr>
                                    <td><span>{{ $item->email }}</span></td>
                                    <td><span>{{ $item->name }}</span></td>
                                    <td><span>{{ $item->cuit }}</span></td>
                                    <td><span>{{ $item->razon }}</span></td>
                                    <td><span>{{ $item->address }}</span></td>
                                    <td><span>{{ $item->created_at }}</span></td>
                                    <td>
                                        <span>
                                            {{-- @if (auth()->user()->administrator && $item->status_id < 3)
                                                <a href="{{ route('orders.edit', $item->id) }}" class="btn disabled mr-2"><i class="material-icons">edit</i></a>
                                            @endif --}}

                                            <div style="display: inline-block;" class="dropdown">
                                                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                    <a class="dropdown-item" href="{{ route('users.edit', $item->id) }}" class="btn mr-2"><i class="material-icons">edit</i>Editar usuario</a>

                                                    <form action="{{ route('users.destroy', $item->id) }}" class="d-inline" method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button class="dropdown-item" type="submit"><i style="font-size: 16px;" class="material-icons">delete</i>Eliminar usuario</button>
                                                    </form>

                                                </div>
                                            </div>
                                        </span>

                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
