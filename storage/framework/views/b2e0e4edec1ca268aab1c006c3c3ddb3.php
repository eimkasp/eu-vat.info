<?php $__env->startSection('title', 'VAT Rate Changes History - EU VAT Info'); ?>
<?php $__env->startSection('meta_description', 'Complete history of VAT rate changes across European Union countries. Track standard and reduced rate modifications with stability indicators.'); ?>
<?php $__env->startSection('seo'); ?>
    <?php if (isset($component)) { $__componentOriginal84f9df3f620371229981225e7ba608d7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal84f9df3f620371229981225e7ba608d7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.seo-meta','data' => ['title' => 'VAT Rate Changes History - EU Countries | EU VAT Info','description' => 'Complete history of VAT rate changes across all EU countries from 2000 onwards. Track standard and reduced rate modifications with country stability indicators.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('seo-meta'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'VAT Rate Changes History - EU Countries | EU VAT Info','description' => 'Complete history of VAT rate changes across all EU countries from 2000 onwards. Track standard and reduced rate modifications with country stability indicators.']); ?>
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
<?php $__env->stopSection(); ?>

<div class="mx-auto max-w-7xl px-4 py-6 sm:py-12">
    <div>
        <?php if (isset($component)) { $__componentOriginal360d002b1b676b6f84d43220f22129e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal360d002b1b676b6f84d43220f22129e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumbs','data' => ['items' => ['VAT Changelog' => '']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['VAT Changelog' => ''])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal360d002b1b676b6f84d43220f22129e2)): ?>
<?php $attributes = $__attributesOriginal360d002b1b676b6f84d43220f22129e2; ?>
<?php unset($__attributesOriginal360d002b1b676b6f84d43220f22129e2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal360d002b1b676b6f84d43220f22129e2)): ?>
<?php $component = $__componentOriginal360d002b1b676b6f84d43220f22129e2; ?>
<?php unset($__componentOriginal360d002b1b676b6f84d43220f22129e2); ?>
<?php endif; ?>
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-2">VAT Rate Changes History</h1>
            <p class="text-gray-600">Track all VAT rate modifications across EU countries over the past decade</p>
        </div>

        <!-- Historical Heatmap -->
        <div class="mb-8">
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('all-countries-vat-history', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-1827303819-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
        </div>

        <!-- Country Stability Overview -->
        <div class="bg-white p-6 rounded-xl shadow-xl mb-6">
            <h2 class="text-xl font-bold mb-4">📊 Country Stability Indicators</h2>
            <p class="text-sm text-gray-600 mb-4">Countries with fewer VAT rate changes indicate more stable tax environments</p>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                <?php $__currentLoopData = $countryStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center gap-2 p-3 border rounded-lg hover:bg-gray-50 transition-colors">
                        <img src="https://flagcdn.com/h40/<?php echo e(strtolower($stat['iso_code'])); ?>.jpg" 
                             alt="<?php echo e($stat['name']); ?>" 
                             class="w-8 h-5 object-cover rounded shadow-sm">
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-medium truncate"><?php echo e($stat['name']); ?></div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-gray-500"><?php echo e($stat['changes_count']); ?> changes</span>
                                <?php if($stat['stability'] === 'excellent'): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                        Excellent
                                    </span>
                                <?php elseif($stat['stability'] === 'good'): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                        Good
                                    </span>
                                <?php elseif($stat['stability'] === 'moderate'): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Moderate
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                        Frequent
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white p-6 rounded-xl shadow-xl mb-6">
            <h3 class="font-bold mb-4">Filters</h3>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                    <select wire:model.live="selectedCountry" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Countries</option>
                        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($country->id); ?>"><?php echo e($country->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rate Type</label>
                    <select wire:model.live="selectedType" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Types</option>
                        <option value="standard">Standard Rate</option>
                        <option value="reduced">Reduced Rate</option>
                        <option value="super_reduced">Super Reduced Rate</option>
                        <option value="parking">Parking Rate</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Changes List -->
        <div class="bg-white rounded-xl shadow-xl overflow-hidden">
            <div class="p-6 border-b bg-gray-50">
                <h3 class="font-bold">All Changes (Past 10 Years)</h3>
            </div>
            
            <?php if($changes->count() > 0): ?>
                <div class="divide-y">
                    <?php $__currentLoopData = $changes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $change): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="p-6 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center gap-4 flex-1">
                                    <img src="https://flagcdn.com/h40/<?php echo e(strtolower($change->country->iso_code)); ?>.jpg" 
                                         alt="<?php echo e($change->country->name); ?>" 
                                         class="w-12 h-8 object-cover rounded shadow-sm">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-1">
                                            <h4 class="font-bold text-lg"><?php echo e($change->country->name); ?></h4>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <?php echo e(ucfirst(str_replace('_', ' ', $change->type))); ?>

                                            </span>
                                        </div>
                                        <div class="text-gray-600">
                                            <span class="font-medium text-2xl text-blue-600"><?php echo e($change->rate); ?>%</span>
                                            <span class="text-sm ml-2">effective from <?php echo e($change->effective_from->format('F d, Y')); ?></span>
                                        </div>
                                        <?php if($change->effective_to): ?>
                                            <div class="text-sm text-gray-500 mt-1">
                                                Valid until: <?php echo e($change->effective_to->format('F d, Y')); ?>

                                            </div>
                                        <?php else: ?>
                                            <div class="text-sm text-green-600 mt-1">
                                                ✓ Currently active
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <a href="<?php echo e(route('vat-calculator.country', $change->country->slug)); ?>" 
                                       class="text-sm text-blue-600 hover:underline">
                                        View Calculator →
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Pagination -->
                <div class="p-6 border-t bg-gray-50">
                    <?php echo e($changes->links()); ?>

                </div>
            <?php else: ?>
                <div class="p-12 text-center text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p>No VAT rate changes found matching your criteria</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div><?php /**PATH /home/runner/work/eu-vat.info/eu-vat.info/resources/views/livewire/vat-changes-history.blade.php ENDPATH**/ ?>