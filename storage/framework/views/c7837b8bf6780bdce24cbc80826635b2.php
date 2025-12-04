<?php $__env->startSection('content'); ?>
    <div class="p-6">
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('vat-calculator-form', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-785088137-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
        <div class="mt-3 text-right">
            Powered by <a href="https://eu-vat.info" target="_blank" class="text-blue-500">EU-VAT.info</a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.layouts.app-embed', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/runner/work/eu-vat.info/eu-vat.info/resources/views/widget/iframe.blade.php ENDPATH**/ ?>