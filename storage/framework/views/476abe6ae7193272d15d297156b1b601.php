<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>

    <title><?php echo $__env->yieldContent('title', 'EU VAT Widget'); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('meta_description', 'VAT Widget to calculate VAT amount in your country'); ?>">
</head>
<body>
    <div class="">
        <?php if(isset($slot)): ?>
            <?php echo e($slot); ?>

        <?php else: ?>
            <?php echo $__env->yieldContent('content'); ?>
        <?php endif; ?>
    </div>
    <?php if(config('app.data_domain') && app()->isProduction()): ?>
        <script defer data-domain="<?php echo e(config('app.data_domain')); ?>" src="<?php echo e(config('app.plausible_script')); ?>"></script>
    <?php endif; ?>
</body>

</html>
<?php /**PATH /home/runner/work/eu-vat.info/eu-vat.info/resources/views/components/layouts/app-embed.blade.php ENDPATH**/ ?>