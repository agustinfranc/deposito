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

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="activos-tab" data-toggle="tab" href="#activos" role="tab" aria-controls="activos" aria-selected="true">Activos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="finalizados-tab" data-toggle="tab" href="#finalizados" role="tab" aria-controls="finalizados" aria-selected="false">Finalizados</a>
                    </li>
                    </li>
                </ul>

                <div class="card-body">

                    <div class="tab-content" id="myTabContent">

                        <div class="tab-pane fade show active" id="activos" role="tabpanel" aria-labelledby="activos-tab">
                            <div class="d-flex align-items-end flex-column bd-highlight mb-3">
                                <a name="todos" id="todos" class="btn btn-primary mr-1" href="{{ route('stock.index') }}" role="button">Nuevo</a>
                            </div>
        
                            <ul id="lista-productos" class="list-group mt-3">
                                @foreach($pedidos as $item)
                                    {{-- Ejemplo --}}
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <strong>#{{ $item->id }}</strong>
                                        <span>{{ $item->fecha }}</span>
                                        <span>${{ $item->total }}</span>
        
                                        <div class="float-right">
            
                                            <a href="{{ route('pedidos.show', $item->id) }}" class="mr-2"><i class="material-icons">more</i></a>
        
                                        </div>

                                        @if (auth()->user()->permiso)
                                            <div class="float-right">
            
                                                <a href="{{ route('pedidos.edit', $item->id) }}" class="btn btn-warning btn-sm mr-2"><i class="material-icons">edit</i></a>
            
                                                <form action="{{ route('pedidos.destroy', $item->id) }}" class="d-inline" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="btn btn-danger btn-sm" type="submit"><i class="material-icons">delete</i></button>
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

{{-- @push('scripts')
    <script src="{{ asset('js/stock.js') }}" defer></script>
@endpush --}}