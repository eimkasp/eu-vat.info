@props([
    'title' => 'EU VAT Info - VAT Rates Calculator & Information',
    'description' => 'Calculate VAT for all EU countries. Current rates, historical data, and VAT compliance tools. Free calculator with real-time rates.',
    'url' => url()->current(),
    'image' => asset('images/og-image.jpg'),
    'type' => 'website'
])

<!-- Primary Meta Tags -->
<title>{{ $title }}</title>
<meta name="title" content="{{ $title }}">
<meta name="description" content="{{ $description }}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="{{ $type }}">
<meta property="og:url" content="{{ $url }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image" content="{{ $image }}">
<meta property="og:site_name" content="EU VAT Info">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ $url }}">
<meta property="twitter:title" content="{{ $title }}">
<meta property="twitter:description" content="{{ $description }}">
<meta property="twitter:image" content="{{ $image }}">

<!-- Additional SEO -->
<link rel="canonical" href="{{ $url }}">
<meta name="robots" content="index, follow">
<meta name="googlebot" content="index, follow">

{{ $slot }}
