@component('mail::message')
# {{ $subject }}

<div align="justify">
{{ $message }}
</div><br />

{{ $name }},<br>
{{ $phone }}
@endcomponent
