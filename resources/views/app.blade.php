<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Generics -->
    <link rel="icon" href="{{ cdn('images/favicon/favicon-32.png') }}" sizes="32x32">
    <link rel="icon" href="{{ cdn('images/favicon/favicon-128.png') }}" sizes="128x128">
    <link rel="icon" href="{{ cdn('images/favicon/favicon-192.png') }}" sizes="192x192">

    <!-- Android -->
    <link rel="shortcut icon" href="{{ cdn('images/favicon/favicon-196.png') }}" sizes="196x196">

    <!-- iOS -->
    <link rel="apple-touch-icon" href="{{ cdn('images/favicon/favicon-152.png') }}" sizes="152x152">
    <link rel="apple-touch-icon" href="{{ cdn('images/favicon/favicon-167.png') }}" sizes="167x167">
    <link rel="apple-touch-icon" href="{{ cdn('images/favicon/favicon-180.png') }}" sizes="180x180">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <!-- Scripts -->
    @routes
    <script defer src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_CLIENT_ID') }}" data-sdk-integration-source="button-factory"></script>
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>

<body class="font-sans antialiased">
    @inertia

    @env('local')
    <script src="http://localhost:8080/js/bundle.js"></script>
    @endenv
</body>

</html>
