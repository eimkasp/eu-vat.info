<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#3b82f6">
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>

    <!-- SEO Meta Tags -->
    <?php if (! empty(trim($__env->yieldContent('seo')))): ?>
        <?php echo $__env->yieldContent('seo'); ?>
    <?php else: ?>
        <?php if (isset($component)) { $__componentOriginal84f9df3f620371229981225e7ba608d7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal84f9df3f620371229981225e7ba608d7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.seo-meta','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('seo-meta'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal84f9df3f620371229981225e7ba608d7)): ?>
<?php $attributes = $__attributesOriginal84f9df3f620371229981225e7ba608d7; ?>
<?php unset($__attributesOriginal84f9df3f620371229981225e7ba608d7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal84f9df3f620371229981225e7ba608d7)): ?>
<?php $component = $__componentOriginal84f9df3f620371229981225e7ba608d7; ?>
<?php unset($__componentOriginal84f9df3f620371229981225e7ba608d7); ?>
<?php endif; ?>
    <?php endif; ?>
    
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(registration => {
                        console.log('ServiceWorker registration successful with scope: ', registration.scope);
                    }, err => {
                        console.log('ServiceWorker registration failed: ', err);
                    });
            });
        }
    </script>

    <?php if(config('app.adsense_id') && app()->isProduction()): ?>
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=<?php echo e(config('app.adsense_id')); ?>"
            crossorigin="anonymous"></script>
    <?php endif; ?>
    <?php if(config('app.data_domain') && app()->isProduction()): ?>
        <script defer data-domain="<?php echo e(config('app.data_domain')); ?>" src="<?php echo e(config('app.plausible_script')); ?>"></script>
    <?php endif; ?>
    <style>
        :root {
            --primary: #4F46E5;
            --primary-dark: #4338CA;
            --secondary: #0EA5E9;
            --accent: #F59E0B;
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
            --background: #F8FAFC;
            --surface: #FFFFFF;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100">
    <?php if (isset($component)) { $__componentOriginalbb0d0c44ec5006fdb1f9ae77f46dbcf9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbb0d0c44ec5006fdb1f9ae77f46dbcf9 = $attributes; } ?>
<?php $component = App\View\Components\GlobalHeader::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('global-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\GlobalHeader::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbb0d0c44ec5006fdb1f9ae77f46dbcf9)): ?>
<?php $attributes = $__attributesOriginalbb0d0c44ec5006fdb1f9ae77f46dbcf9; ?>
<?php unset($__attributesOriginalbb0d0c44ec5006fdb1f9ae77f46dbcf9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbb0d0c44ec5006fdb1f9ae77f46dbcf9)): ?>
<?php $component = $__componentOriginalbb0d0c44ec5006fdb1f9ae77f46dbcf9; ?>
<?php unset($__componentOriginalbb0d0c44ec5006fdb1f9ae77f46dbcf9); ?>
<?php endif; ?>

    <div class="bg-gray-100">
    <div class="absolute top-0 left-0 w-full h-[100px] opacity-20 z-0">
    </div>
    <div class="relative z-[2]">
        <?php if(isset($slot)): ?>
            <?php echo e($slot); ?>

        <?php else: ?>
            <?php echo $__env->yieldContent('content'); ?>
        <?php endif; ?>
        </div>
    </div>
    <?php if(config('app.adsense_id') && app()->isProduction()): ?>
        <!-- Default -->
        <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-3925599852702124" data-ad-slot="1306180870"
            data-ad-format="auto" data-full-width-responsive="true"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    <?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal8a8716efb3c62a45938aca52e78e0322 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8a8716efb3c62a45938aca52e78e0322 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.footer','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8a8716efb3c62a45938aca52e78e0322)): ?>
<?php $attributes = $__attributesOriginal8a8716efb3c62a45938aca52e78e0322; ?>
<?php unset($__attributesOriginal8a8716efb3c62a45938aca52e78e0322); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8a8716efb3c62a45938aca52e78e0322)): ?>
<?php $component = $__componentOriginal8a8716efb3c62a45938aca52e78e0322; ?>
<?php unset($__componentOriginal8a8716efb3c62a45938aca52e78e0322); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal2aca76be1376419dfd37220f36011753 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2aca76be1376419dfd37220f36011753 = $attributes; } ?>
<?php $component = Mary\View\Components\Toast::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('toast'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Toast::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2aca76be1376419dfd37220f36011753)): ?>
<?php $attributes = $__attributesOriginal2aca76be1376419dfd37220f36011753; ?>
<?php unset($__attributesOriginal2aca76be1376419dfd37220f36011753); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2aca76be1376419dfd37220f36011753)): ?>
<?php $component = $__componentOriginal2aca76be1376419dfd37220f36011753; ?>
<?php unset($__componentOriginal2aca76be1376419dfd37220f36011753); ?>
<?php endif; ?>

    <?php if(config('app.cookiebot_id') && app()->isProduction()): ?>
        <script defer id="Cookiebot" src="https://consent.cookiebot.com/uc.js" data-cbid="<?php echo e(config('app.cookiebot_id')); ?>"
            data-blockingmode="auto" type="text/javascript"></script>
    <?php endif; ?>
</body>

</html>
<?php /**PATH /home/runner/work/eu-vat.info/eu-vat.info/resources/views/components/layouts/app.blade.php ENDPATH**/ ?>