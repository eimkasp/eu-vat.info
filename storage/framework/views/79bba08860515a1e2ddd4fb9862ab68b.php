<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['position']));

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

foreach (array_filter((['position']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $banners = \App\Models\Banner::active()
        ->where('position', $position)
        ->get();
?>

<?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="banner-container my-4">
        <a href="<?php echo e($banner->link_url); ?>" target="_blank" rel="noopener noreferrer" class="block hover:opacity-90 transition-opacity">
            <?php if($banner->image): ?>
                <img src="<?php echo e(Storage::url($banner->image)); ?>" alt="<?php echo e($banner->title); ?>" class="w-full rounded-lg shadow-md">
            <?php elseif($banner->content): ?>
                <div class="bg-white rounded-lg shadow-md p-4">
                    <?php echo $banner->content; ?>

                </div>
            <?php endif; ?>
        </a>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/runner/work/eu-vat.info/eu-vat.info/resources/views/components/banner-display.blade.php ENDPATH**/ ?>