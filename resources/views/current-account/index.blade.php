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

                    <table class="table my-3">
                        <thead>
                            <tr>
                            @if (auth()->user()->administrator)
                                <th scope="col">Cliente</th>
                            @endif
                            {{-- <th scope="col">Total</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $item)
                                @if ($item->status_id < 6)
                                    <tr>
                                        @if (auth()->user()->administrator)
                                            <td><span>{{ $item->email }}</span></td>
                                        @endif
                                        {{-- <td><span>${{ $item->total }}</span></td> --}}

                                    </tr>
                                @endif
                            @endforeach

                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>

    <div class="d-flex flex-row-reverse mt-3">
        <a href="{{ route('home') }}" class="btn btn-outline-primary">Volver</a>
    </div>

</div>
@endsection