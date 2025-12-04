<image:image>
<?php if(! empty($image->url)): ?>
    <image:loc><?php echo e(url($image->url)); ?></image:loc>
<?php endif; ?>
<?php if(! empty($image->caption)): ?>
    <image:caption><?php echo e($image->caption); ?></image:caption>
<?php endif; ?>
<?php if(! empty($image->geo_location)): ?>
    <image:geo_location><?php echo e($image->geo_location); ?></image:geo_location>
<?php endif; ?>
<?php if(! empty($image->title)): ?>
    <image:title><?php echo e($image->title); ?></image:title>
<?php endif; ?>
<?php if(! empty($image->license)): ?>
    <image:license><?php echo e($image->license); ?></image:license>
<?php endif; ?>
</image:image>
<?php /**PATH /home/runner/work/eu-vat.info/eu-vat.info/vendor/spatie/laravel-sitemap/resources/views/image.blade.php ENDPATH**/ ?>