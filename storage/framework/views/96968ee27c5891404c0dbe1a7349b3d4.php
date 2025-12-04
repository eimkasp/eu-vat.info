<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['label', 'options']));

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

foreach (array_filter((['label', 'options']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>
<div <?php echo e($attributes->only('class')->merge(['class' => 'flex border border-gray-200 dark:border-gray-700 overflow-hidden rounded-md focus-within:ring'])); ?>>
    <label class="px-3 flex items-center border-r border-gray-200 dark:border-gray-700 text-xs sm:text-sm text-gray-600 dark:text-gray-300 whitespace-nowrap bg-gray-100 dark:bg-gray-800/50"><?php echo e($label); ?></label>
    <select
        <?php echo e($attributes->except('class')); ?>

        class="overflow-ellipsis w-full border-0 pl-3 pr-8 py-1 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-xs sm:text-sm shadow-none focus:ring-0"
    >
        <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($value); ?>"><?php echo e($label); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>
<?php /**PATH /home/runner/work/eu-vat.info/eu-vat.info/vendor/laravel/pulse/resources/views/components/select.blade.php ENDPATH**/ ?>