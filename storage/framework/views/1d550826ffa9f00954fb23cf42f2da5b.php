<?php $__env->startSection('seo'); ?>
    <?php if (isset($component)) { $__componentOriginal84f9df3f620371229981225e7ba608d7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal84f9df3f620371229981225e7ba608d7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.seo-meta','data' => ['title' => 'EU VAT Info - VAT Rates Calculator & Information for All EU Countries','description' => 'Current VAT rates for all 27 EU countries. Free online calculator, historical data from 2000, rate change alerts, and compliance guides. Updated daily.','type' => 'website']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('seo-meta'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'EU VAT Info - VAT Rates Calculator & Information for All EU Countries','description' => 'Current VAT rates for all 27 EU countries. Free online calculator, historical data from 2000, rate change alerts, and compliance guides. Updated daily.','type' => 'website']); ?>
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebSite",
            "name": "EU VAT Info",
            "url": "<?php echo e(url('/')); ?>",
            "description": "VAT rates and calculator for all EU countries",
            "potentialAction": {
                "@type": "SearchAction",
                "target": {
                    "@type": "EntryPoint",
                    "urlTemplate": "<?php echo e(url('/')); ?>?search={search_term_string}"
                },
                "query-input": "required name=search_term_string"
            }
        }
        </script>
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

<div class="mx-auto max-w-7xl px-4 py-6 sm:py-12" x-data="{ showMap: true }">
    <div class="text-center mb-16 max-w-3xl mx-auto">
        <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 tracking-tight mb-4">
            VAT Rates in the <span class="text-blue-600">European Union</span>
        </h1>
        <p class="text-xl text-gray-500 leading-relaxed">
            Current standard VAT rates, reduced rates, and calculator for all 27 EU member states. Updated daily.
        </p>
    </div>

    <div class="md:grid md:grid-cols-12 gap-12">


        <div class="md:col-span-8 lg:col-span-7">
            <div class="flex flex-col gap-2 bg-white rounded shadow-xl">


                <div class="">


                    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
                        <div class="p-4 border-b border-gray-100 bg-gray-50/50">
                            <div class="relative">
                                <input wire:model.live="search"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border-0 ring-1 ring-gray-200 focus:ring-2 focus:ring-blue-500 bg-white shadow-sm transition-all"
                                    placeholder="Search for a country..." type="search">
                                <div class="absolute left-3 top-3.5 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                    </svg>
                                </div>
                                <div wire:loading wire:target="search" class="absolute right-3 top-3.5 text-blue-500">
                                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="overflow-x-auto" wire:loading.class="opacity-50" wire:target="search">
                            <table class="w-full text-left text-sm text-gray-600">
                                <thead class="bg-gray-50 text-xs uppercase font-semibold text-gray-500 tracking-wider">
                                    <tr>
                                        <th class="px-6 py-4">Country</th>
                                        <th class="px-6 py-4">Standard Rate</th>
                                        <th class="px-6 py-4 hidden sm:table-cell">Reduced</th>
                                        <th class="px-6 py-4 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <?php $__currentLoopData = $euCountries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="hover:bg-blue-50/50 transition-colors group">
                                            <td class="px-6 py-4">
                                                <button wire:click="selectCountry('<?php echo e($country->slug); ?>')"
                                                    class="flex items-center gap-4 group-hover:text-blue-600 transition-colors">
                                                    <span
                                                        class="font-mono text-xs text-gray-300 w-6">#<?php echo e($country->countryRank()); ?></span>
                                                    <img src="https://flagcdn.com/h40/<?php echo e(strtolower($country->iso_code)); ?>.jpg"
                                                        alt="<?php echo e($country->name); ?>"
                                                        class="h-6 w-auto rounded-sm shadow-sm">
                                                    <span
                                                        class="font-bold text-gray-900 group-hover:text-blue-600"><?php echo e($country->name); ?></span>
                                                </button>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-bold bg-blue-100 text-blue-800">
                                                    <?php echo e($country->standard_rate); ?>%
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 hidden sm:table-cell">
                                                <?php if($country->reduced_rate): ?>
                                                    <span class="text-gray-500"><?php echo e($country->reduced_rate); ?>%</span>
                                                    <?php if($country->super_reduced_rate): ?>
                                                        <span
                                                            class="text-gray-400 text-xs ml-1">(<?php echo e($country->super_reduced_rate); ?>%)</span>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span class="text-gray-300">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <a href="<?php echo e(route('vat-calculator.country', $country->slug)); ?>"
                                                    class="text-blue-600 font-medium hover:text-blue-800 text-xs uppercase tracking-wide transition-colors">
                                                    Details &rarr;
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <div class="md:col-span-4 lg:col-span-5">
            <!-- Calculator Widget -->
            <div class="mb-6">
                <?php if($selectedCountry): ?>
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('vat-calculator-form', ['slug' => $selectedCountry->slug]);

$__html = app('livewire')->mount($__name, $__params, 'calc-'.$selectedCountry->id, $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                    
                    <div class="mt-2 pt-2 border-t">
                        <a href="<?php echo e(route('vat-calculator.country', $selectedCountry->slug)); ?>" 
                           class="text-blue-600 hover:underline text-sm">
                            View full calculator & history →
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- VAT Rate Changes Widget -->
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('vat-rate-changes', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-2341749709-3', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            
            <!-- Sidebar Banners -->
            <?php if (isset($component)) { $__componentOriginale783cf2f069f755e6c9cc2080fac9748 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale783cf2f069f755e6c9cc2080fac9748 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.banner-display','data' => ['position' => 'sidebar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('banner-display'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['position' => 'sidebar']); ?>
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
            
            <!-- Useful Links Widget -->
            <?php if (isset($component)) { $__componentOriginal91e823333e9fcecca769f11dd46e639a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal91e823333e9fcecca769f11dd46e639a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.useful-vat-links','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('useful-vat-links'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91e823333e9fcecca769f11dd46e639a)): ?>
<?php $attributes = $__attributesOriginal91e823333e9fcecca769f11dd46e639a; ?>
<?php unset($__attributesOriginal91e823333e9fcecca769f11dd46e639a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91e823333e9fcecca769f11dd46e639a)): ?>
<?php $component = $__componentOriginal91e823333e9fcecca769f11dd46e639a; ?>
<?php unset($__componentOriginal91e823333e9fcecca769f11dd46e639a); ?>
<?php endif; ?>
            
            <!-- Recent Countries & Map -->
            <div>
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('recent-countries', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-2341749709-4', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                <div class="bg-white p-6 shadow-xl rounded-xl">
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('europe-map', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-2341749709-5', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                </div>
            </div>
        </div>
    </div>



</div>


</div><?php /**PATH /home/runner/work/eu-vat.info/eu-vat.info/resources/views/livewire/home.blade.php ENDPATH**/ ?>