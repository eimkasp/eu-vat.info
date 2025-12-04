<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title' => 'EU VAT Info - VAT Rates Calculator & Information',
    'description' => 'Calculate VAT for all EU countries. Current rates, historical data, and VAT compliance tools. Free calculator with real-time rates.',
    'url' => url()->current(),
    'image' => asset('images/og-image.jpg'),
    'type' => 'website'
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'title' => 'EU VAT Info - VAT Rates Calculator & Information',
    'description' => 'Calculate VAT for all EU countries. Current rates, historical data, and VAT compliance tools. Free calculator with real-time rates.',
    'url' => url()->current(),
    'image' => asset('images/og-image.jpg'),
    'type' => 'website'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<!-- Primary Meta Tags -->
<title><?php echo e($title); ?></title>
<meta name="title" content="<?php echo e($title); ?>">
<meta name="description" content="<?php echo e($description); ?>">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="<?php echo e($type); ?>">
<meta property="og:url" content="<?php echo e($url); ?>">
<meta property="og:title" content="<?php echo e($title); ?>">
<meta property="og:description" content="<?php echo e($description); ?>">
<meta property="og:image" content="<?php echo e($image); ?>">
<meta property="og:site_name" content="EU VAT Info">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="<?php echo e($url); ?>">
<meta property="twitter:title" content="<?php echo e($title); ?>">
<meta property="twitter:description" content="<?php echo e($description); ?>">
<meta property="twitter:image" content="<?php echo e($image); ?>">

<!-- Additional SEO -->
<link rel="canonical" href="<?php echo e($url); ?>">
<meta name="robots" content="index, follow">
<meta name="googlebot" content="index, follow">

<?php echo e($slot); ?>

<?php /**PATH /home/runner/work/eu-vat.info/eu-vat.info/resources/views/components/seo-meta.blade.php ENDPATH**/ ?>