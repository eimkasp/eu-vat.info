<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['method']));

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

foreach (array_filter((['method']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
$colorClasses = match ($method) {
    'GET', 'OPTIONS' => 'text-purple-400 dark:text-purple-300 bg-purple-50 dark:bg-purple-900 border-purple-200 dark:border-purple-700',
    'POST', 'PUT', 'PATCH' => 'text-blue-400 dark:text-blue-300 bg-blue-50 dark:bg-blue-900 border-blue-200 dark:border-blue-700',
    'DELETE' => 'text-red-400 dark:text-red-300 bg-red-50 dark:bg-red-900 border-red-200 dark:border-red-700',
    default => 'text-gray-400 dark:text-gray-100 bg-gray-50 dark:bg-gray-700 border-gray-200 dark:border-gray-500',
}
?>

<span <?php echo e($attributes->merge(['class' => "text-xs font-mono px-1 border rounded font-semibold $colorClasses"])); ?>><?php echo e($method); ?></span>
<?php /**PATH /home/runner/work/eu-vat.info/eu-vat.info/vendor/laravel/pulse/resources/views/components/http-method-badge.blade.php ENDPATH**/ ?>