@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
{{ config('app.name') }}
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
<img src="{{ asset('images/logo/logo.png') }}" class="logo" alt="HJ Autopartes"><br/>
{{-- © {{ date('Y') }} HJ ACCO AUTOPARTES S.A. DE C.V.<br/> @lang('All rights reserved.')<br/>Blvd Los Alamos #195 Int A Col Los Alamos<br/>CP. 84085. Nogales, Sonora México --}}
<small>© {{ date('Y') }} HJ Acco Autopartes S.A. de C.V. @lang('All rights reserved.') HJ Autopartes, HJAutopartes.com.mx, el logo de HJAutopartes.com.mx es marca registradas de HJ Acco Autopartes. Servicios HJ Acco Autopartes S.A. de C.V. con domicilio en Blvd. Los Alamos #195 interior A, Colonia Los Alamos, Nogales, C.P. 84085, Sonora. En caso de que desees ponerte en contacto por teléfono, correo electrónico o chat con HJ Autopartes, favor de contactar nuestro Servicio al Cliente.<br /><br />Este correo fue enviado desde una dirección solamente de notificaciones que no puede aceptar correo electrónico entrante. Por favor no respondas a este mensaje.</small>
@endcomponent
@endslot
@endcomponent
