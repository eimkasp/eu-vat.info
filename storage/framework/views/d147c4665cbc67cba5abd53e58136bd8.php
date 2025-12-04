<?php app("livewire")->forceAssetInjection(); ?><div x-persist="<?php echo e('navigation'); ?>">
<header x-data="{ mobileMenuOpen: false }" class="bg-[#003399] text-white sticky top-0 z-[99] shadow-xl">
    <div class="container !py-4 !px-4 sm:!px-6">
        <div class="flex justify-between items-center">
            
            <div class="flex items-center">
                <a wire:navigate class="font-extrabold text-xl" href="/">
                    EU VAT Info
                </a>
            </div>

            
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            
            <nav class="hidden md:flex items-center gap-6">
                <a wire:navigate="/" href="/" title="EU VAT countries list">All Countries</a>
                <a wire:navigate="/vat-calculator" href="/vat-calculator">VAT Calculator</a>
                <a wire:navigate="<?php echo e(route('widget.embed')); ?>" href="<?php echo e(route('widget.embed')); ?>">VAT Widget</a>
                <a wire:navigate=<?php echo e(route('vat-map')); ?> href="<?php echo e(route('vat-map')); ?>">VAT Map</a>
                <a wire:navigate=<?php echo e(route('vat-changes')); ?> href="<?php echo e(route('vat-changes')); ?>">VAT Changelog</a>
                
                <a href="https://github.com/eimkasp/eu-vat.info" target="_blank" class="w-6">
                    <?php echo e(svg('feathericon-github')); ?>
                </a>
            </nav>
        </div>

        
        <nav x-cloak x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden mt-4 space-y-3">
            <a wire:navigate="/" href="/" class="block py-2" title="EU VAT countries list">All Countries</a>
            <a wire:navigate="/vat-calculator" href="/vat-calculator" class="block py-2">VAT Calculator 💶</a>
            <a wire:navigate="<?php echo e(route('widget.embed')); ?>" href="<?php echo e(route('widget.embed')); ?>" class="block py-2">VAT Widget</a>
            <a wire:navigate=<?php echo e(route('vat-map')); ?> href="<?php echo e(route('vat-map')); ?>" class="block py-2">VAT Map 🌍</a>
            <a wire:navigate=<?php echo e(route('vat-changes')); ?> href="<?php echo e(route('vat-changes')); ?>" class="block py-2">VAT Changelog 📈</a>
            
            <a href="https://github.com/eimkasp/eu-vat.info" target="_blank" class="block py-2">
                GitHub <?php echo e(svg('feathericon-github', 'inline-block w-5 h-5 ml-1')); ?>
            </a>
        </nav>
    </div>
</header>


<?php if (isset($component)) { $__componentOriginal86113d2cacef811d2f2308f428be36ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal86113d2cacef811d2f2308f428be36ee = $attributes; } ?>
<?php $component = App\View\Components\AnnouncementBar::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('announcement-bar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AnnouncementBar::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal86113d2cacef811d2f2308f428be36ee)): ?>
<?php $attributes = $__attributesOriginal86113d2cacef811d2f2308f428be36ee; ?>
<?php unset($__attributesOriginal86113d2cacef811d2f2308f428be36ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal86113d2cacef811d2f2308f428be36ee)): ?>
<?php $component = $__componentOriginal86113d2cacef811d2f2308f428be36ee; ?>
<?php unset($__componentOriginal86113d2cacef811d2f2308f428be36ee); ?>
<?php endif; ?>

</div>
<?php if (isset($component)) { $__componentOriginala63d75e61bed68e54e4eb96168fa8146 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala63d75e61bed68e54e4eb96168fa8146 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.bottom-navigation','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('bottom-navigation'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala63d75e61bed68e54e4eb96168fa8146)): ?>
<?php $attributes = $__attributesOriginala63d75e61bed68e54e4eb96168fa8146; ?>
<?php unset($__attributesOriginala63d75e61bed68e54e4eb96168fa8146); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala63d75e61bed68e54e4eb96168fa8146)): ?>
<?php $component = $__componentOriginala63d75e61bed68e54e4eb96168fa8146; ?>
<?php unset($__componentOriginala63d75e61bed68e54e4eb96168fa8146); ?>
<?php endif; ?>
<?php /**PATH /home/runner/work/eu-vat.info/eu-vat.info/resources/views/components/global-header.blade.php ENDPATH**/ ?>