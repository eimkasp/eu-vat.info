<input
    <?php echo e($attributes
            ->merge([
                'id' => $getId(),
                'type' => 'hidden',
                $applyStateBindingModifiers('wire:model') => $getStatePath(),
            ], escape: false)
            ->merge($getExtraAttributes(), escape: false)
            ->class(['fi-fo-hidden'])); ?>

/>
<?php /**PATH /home/runner/work/eu-vat.info/eu-vat.info/vendor/filament/forms/resources/views/components/hidden.blade.php ENDPATH**/ ?>