<video:video>
    <video:thumbnail_loc><?php echo e($video->thumbnailLoc); ?></video:thumbnail_loc>
    <video:title><?php echo e($video->title); ?></video:title>
    <video:description><?php echo e($video->description); ?></video:description>
<?php if($video->contentLoc): ?>
    <video:content_loc><?php echo e($video->contentLoc); ?></video:content_loc>
<?php endif; ?>
<?php if($video->playerLoc): ?>
    <video:player_loc><?php echo e($video->playerLoc); ?></video:player_loc>
<?php endif; ?>
<?php $__currentLoopData = $video->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <video:<?php echo e($tag); ?>><?php echo e($value); ?></video:<?php echo e($tag); ?>>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__currentLoopData = $video->allow; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <video:<?php echo e($tag); ?> relationship="allow"><?php echo e($value); ?></video:<?php echo e($tag); ?>>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__currentLoopData = $video->deny; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <video:<?php echo e($tag); ?> relationship="deny"><?php echo e($value); ?></video:<?php echo e($tag); ?>>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__currentLoopData = $video->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <video:tag><?php echo e($tag); ?></video:tag>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</video:video>
<?php /**PATH /home/runner/work/eu-vat.info/eu-vat.info/vendor/spatie/laravel-sitemap/resources/views/video.blade.php ENDPATH**/ ?>