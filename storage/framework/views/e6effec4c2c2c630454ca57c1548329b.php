<div
    x-data="{}"
    x-on:click="$dispatch('open-modal', { id: 'database-notifications' })"
    <?php echo e($attributes->class(['inline-block'])); ?>

>
    <?php echo e($slot); ?>

</div>
<?php /**PATH /home/runner/work/eu-vat.info/eu-vat.info/vendor/filament/notifications/resources/views/components/database/trigger.blade.php ENDPATH**/ ?>