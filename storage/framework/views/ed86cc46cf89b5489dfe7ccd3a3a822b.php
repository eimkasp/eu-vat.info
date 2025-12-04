<?php
    $count = 1;
    if ($country->reduced_rate) $count++;
    if ($country->parking_rate) $count++;
    if ($country->super_reduced_rate) $count++;
    
    $gridCols = 'grid-cols-2';
    if ($count >= 3) {
        $gridCols = 'grid-cols-2 sm:grid-cols-3';
    }
?>

<div>
    <h3 class="text-base font-semibold leading-6 text-gray-900 mb-3">Available VAT rates in <?php echo e($country->name); ?></h3>
    <dl class="grid <?php echo e($gridCols); ?> gap-3">
        <div class="overflow-hidden rounded-lg bg-white p-3 shadow">
            <dt class="truncate text-xs font-medium text-gray-500">Standard rate</dt>
            <dd class="mt-1 text-2xl font-semibold tracking-tight text-gray-900">
                <?php echo e($country->standard_rate); ?>%
            </dd>
        </div>
        
        <?php if($country->reduced_rate): ?>
        <div class="overflow-hidden rounded-lg bg-white p-3 shadow">
            <dt class="truncate text-xs font-medium text-gray-500">Reduced rate</dt>
            <dd class="mt-1 text-2xl font-semibold tracking-tight text-gray-900">
                <?php echo e($country->reduced_rate); ?>%
            </dd>
        </div>
        <?php endif; ?>

        <?php if($country->parking_rate): ?>
            <div class="overflow-hidden rounded-lg bg-white p-3 shadow">
                <dt class="truncate text-xs font-medium text-gray-500">Parking rate</dt>
                <dd class="mt-1 text-2xl font-semibold tracking-tight text-gray-900">
                    <?php echo e($country->parking_rate); ?>%
                </dd>
            </div>
        <?php endif; ?>

        <?php if($country->super_reduced_rate): ?>
            <div class="overflow-hidden rounded-lg bg-white p-3 shadow">
                <dt class="truncate text-xs font-medium text-gray-500">Super Reduced rate</dt>
                <dd class="mt-1 text-2xl font-semibold tracking-tight text-gray-900">
                    <?php echo e($country->super_reduced_rate); ?>%
                </dd>
            </div>
        <?php endif; ?>
    </dl>
</div>
<?php /**PATH /home/runner/work/eu-vat.info/eu-vat.info/resources/views/components/country-rates.blade.php ENDPATH**/ ?>