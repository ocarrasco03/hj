@component('mail::message')

# Bienvenido a HJ Autopartes

<div align="center">
You've activated your customer account. Next time you shop with us, log in for faster checkout.
</div>
@component('mail::button', ['url' => '', 'color' => 'secondary'])
Reset My Password
@endcomponent
@endcomponent
