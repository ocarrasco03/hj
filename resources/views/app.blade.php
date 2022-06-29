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

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-PKMTG4S');
    </script>
    <!-- End Google Tag Manager -->

    <!-- Scripts -->
    @routes
    <script defer src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_CLIENT_ID') }}"
        data-sdk-integration-source="button-factory"></script>
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Meta Tag -->
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    {!! JsonLd::generate() !!}
</head>

<body class="font-sans antialiased">
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PKMTG4S" height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->
    
    @inertia

    @env('local')
    <script src="http://localhost:8080/js/bundle.js"></script>
    @endenv
</body>

</html>
