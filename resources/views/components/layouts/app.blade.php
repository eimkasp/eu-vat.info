<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>

    <title>@yield('title', 'EU VAT Info')</title>
    <meta name="description" content="@yield('meta_description', 'Our goal is to provide you with the most up-to-date information on VAT in the European Union. And help you guide VAT compliance landscape')">
    <style>
        .container {
            max-width: 1140px;
            margin: 0 auto;
        }

        h1 {
            font-weight: 700 !important;
            font-size: 1.875rem !important;
        }

        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: 600 !important;
            margin-top: 20px !important;
        }

        h2 {
            font-size: 1.6rem !important;
        }

        h3 {
            font-size: 1.4rem !important;
        }

        h4 {
            font-size: 1.25rem !important;
        }

        h5 {
            font-size: 1rem;
        }

        h6 {
            font-size: 1rem;
        }

        p {
            font-size: 1rem;
            line-height: 1.5;
            margin-bottom: 20px !important;
        }


        .country-content a {
            color: blue !important;
            text-decoration: underline !important;
        }

        .sticky-element,
        .sticky-element>div {
            transition: all 0.3s ease;
        }

        .sticky-element.is-pinned {}

        .sticky-element.is-pinned>div {
            margin-top: 100px;
        }

        .sticky-element .country-sub-details {
            transition: all 0.4s ease-in-out !important;
            height: 20px;
        }

        .sticky-element.is-pinned .country-sub-details {
            height: 0px;
            opacity: 0;
            overflow: hidden;
        }
    </style>
</head>

<body>
    <x-global-header></x-global-header>

    <div class="bg-gray-50">
        {{ $slot }}
    </div>

    <x-footer></x-footer>
    <script defer data-domain="eu-vat.info" src="https://stats.businesspress.io/js/script.js"></script>

</body>

</html>
