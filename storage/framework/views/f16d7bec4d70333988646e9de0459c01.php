<sitemap>
    <?php if(! empty($tag->url)): ?>
    <loc><?php echo e(url($tag->url)); ?></loc>
    <?php endif; ?>
    <?php if(! empty($tag->lastModificationDate)): ?>
    <lastmod><?php echo e($tag->lastModificationDate->format(DateTime::ATOM)); ?></lastmod>
    <?php endif; ?>
</sitemap>
<?php /**PATH /home/runner/work/eu-vat.info/eu-vat.info/vendor/spatie/laravel-sitemap/resources/views/sitemapIndex/sitemap.blade.php ENDPATH**/ ?>