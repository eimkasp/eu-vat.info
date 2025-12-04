<div
    <?php echo e($attributes
            ->merge([
                'id' => $getId(),
            ], escape: false)
            ->merge($getExtraAttributes(), escape: false)); ?>

>
    <?php echo e($getChildComponentContainer()); ?>

</div>
<?php /**PATH /home/runner/work/eu-vat.info/eu-vat.info/vendor/filament/infolists/resources/views/components/grid.blade.php ENDPATH**/ ?>