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
© {{ date('Y') }} HJ ACCO AUTOPARTES SA DE CV.<br/> @lang('All rights reserved.')<br/>Blvd Los Alamos #195 Int A Col Los Alamos<br/>CP. 84085. Nogales, Sonora México
@endcomponent
@endslot
@endcomponent
