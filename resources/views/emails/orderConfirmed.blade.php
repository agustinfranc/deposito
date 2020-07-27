@component('mail::message')
# {{ config('app.name') }}

Hola {{ $order->user->name }}.
Aprobamos tu pedido. Número de identificacion #{{ $order->id }}.

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
        @php $total = 0 @endphp
        @foreach ($order->details as $item)
            @php $total += $item->price * $item->quantity @endphp
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
            <td>${{ $total }}</td>
        </tr>
    </tbody>
</table>

Gracias,<br>
{{ config('app.name') }}
@endcomponent
