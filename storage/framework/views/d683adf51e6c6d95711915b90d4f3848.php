<news:news>
    <news:publication>
        <news:name><?php echo e($news->name); ?></news:name>
        <news:language><?php echo e($news->language); ?></news:language>
    </news:publication>
    <news:title><?php echo e($news->title); ?></news:title>
    <news:publication_date><?php echo e($news->publicationDate->toW3cString()); ?></news:publication_date>
<?php $__currentLoopData = $news->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <news:<?php echo e($tag); ?>><?php echo e($value); ?></news:<?php echo e($tag); ?>>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</news:news><?php /**PATH /home/runner/work/eu-vat.info/eu-vat.info/vendor/spatie/laravel-sitemap/resources/views/news.blade.php ENDPATH**/ ?>