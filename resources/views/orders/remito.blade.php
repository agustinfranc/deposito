<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Remito</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <main class="py-4">
            <div class="container" style="border: solid 1px black;">
                <h1 class="text-center" style="margin: 0">Remito N° {{ $order->id }}</h1>

                <div class="row">
                    <div class="col-6" style="border-top: solid 1px  black; border-right: solid 1px  black;">
                        <p>{{ $order->name }}</p>
                        <p>{{ $order->email }}</p>
                        <p>CUIT: {{ $order->cuit }}</p>
                        <p>{{ $order->razon }}</p>
                        <p>{{ $order->address }}</p>
                    </div>
                    <div class="col-6" style="border-top: solid 1px black;">
                        <p>Fecha de emisión: {{ $order->created_at }}</p>
                        <p>Deposito</p>
                        <p>CUIT Deposito</p>
                    </div>
                    <div class="col-12" style="border-top: solid 1px black;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Codigo</th>
                                    <th>Detalle</th>
                                    <th>Cantidad</th>
                                    <th>Importe Unitario</th>
                                    <th>Importe</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detail as $item)
                                    <tr>
                                        <td>{{ $item->code }}</td>
                                        <td>{{ $item->detail }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>${{ $item->price }}</td>
                                        <td>${{ $item->price * $item->quantity }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td>Total</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>${{ $order->total }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </main>
    </div>

    @stack('scripts')
</body>
</html>
