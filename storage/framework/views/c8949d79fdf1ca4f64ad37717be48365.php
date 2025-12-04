<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['numeric' => false]));

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

foreach (array_filter((['numeric' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>
<td <?php echo e($attributes->merge(['class' => 'first:rounded-l-md last:rounded-r-md text-sm bg-gray-50 dark:bg-gray-800/50 first:pl-3 last:pr-3 px-1 @sm:px-3 py-3' . ($numeric ? ' text-right tabular-nums whitespace-nowrap' : '')])); ?>>
    <?php echo e($slot); ?>

</td>
<?php /**PATH /home/runner/work/eu-vat.info/eu-vat.info/vendor/laravel/pulse/resources/views/components/td.blade.php ENDPATH**/ ?>