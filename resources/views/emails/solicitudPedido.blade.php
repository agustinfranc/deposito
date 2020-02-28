@component('mail::message')
# {{ config('app.name') }}

Hola {{ auth()->user()->nombre }},
Recibimos tu solicitud de pedido y la estamos procesando.
Vamos a enviarte un email de confirmacion en breve.

{{-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

Gracias,<br>
{{ config('app.name') }}
@endcomponent
