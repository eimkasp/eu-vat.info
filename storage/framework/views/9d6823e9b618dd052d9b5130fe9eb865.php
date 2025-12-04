<?php if (isset($component)) { $__componentOriginale783cf2f069f755e6c9cc2080fac9748 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale783cf2f069f755e6c9cc2080fac9748 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.banner-display','data' => ['position' => 'header_top']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('banner-display'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['position' => 'header_top']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale783cf2f069f755e6c9cc2080fac9748)): ?>
<?php $attributes = $__attributesOriginale783cf2f069f755e6c9cc2080fac9748; ?>
<?php unset($__attributesOriginale783cf2f069f755e6c9cc2080fac9748); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale783cf2f069f755e6c9cc2080fac9748)): ?>
<?php $component = $__componentOriginale783cf2f069f755e6c9cc2080fac9748; ?>
<?php unset($__componentOriginale783cf2f069f755e6c9cc2080fac9748); ?>
<?php endif; ?>
<?php /**PATH /home/runner/work/eu-vat.info/eu-vat.info/resources/views/components/announcement-bar.blade.php ENDPATH**/ ?>