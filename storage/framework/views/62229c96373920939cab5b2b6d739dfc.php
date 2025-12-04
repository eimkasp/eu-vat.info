<?php if(isset($selectedCountryObject)): ?>
    <?php $__env->startSection('title', 'VAT Calculator - ' . $selectedCountryObject->name); ?>
<?php $__env->startSection('meta_description',
    'Calculate VAT amount for ' .
    $selectedCountryObject->name .
    '. Use our VAT
    calculator to easily calculate VAT for transactions in ' .
    $selectedCountryObject->name .
    '.'); ?>
<?php $__env->startSection('seo'); ?>
    <?php if (isset($component)) { $__componentOriginal84f9df3f620371229981225e7ba608d7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal84f9df3f620371229981225e7ba608d7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.seo-meta','data' => ['title' => 'VAT Calculator - ' . $selectedCountryObject->name . ' | EU VAT Info','description' => 'Calculate VAT for ' .
        $selectedCountryObject->name .
        '. Standard rate: ' .
        $selectedCountryObject->standard_rate .
        '%. Historical data from 2000. Free calculator with real-time rates.','url' => route('vat-calculator.country', $selectedCountryObject->slug)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('seo-meta'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('VAT Calculator - ' . $selectedCountryObject->name . ' | EU VAT Info'),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Calculate VAT for ' .
        $selectedCountryObject->name .
        '. Standard rate: ' .
        $selectedCountryObject->standard_rate .
        '%. Historical data from 2000. Free calculator with real-time rates.'),'url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('vat-calculator.country', $selectedCountryObject->slug))]); ?>
        <!-- Schema.org JSON-LD -->
        <script type="application/ld+json">
             {
                 "@context": "https://schema.org",
                 "@type": "WebApplication",
                 "name": "<?php echo e($selectedCountryObject->name); ?> VAT Calculator",
                 "description": "Calculate VAT for <?php echo e($selectedCountryObject->name); ?>. Standard rate: <?php echo e($selectedCountryObject->standard_rate); ?>%",
                 "url": "<?php echo e(route('vat-calculator.country', $selectedCountryObject->slug)); ?>",
                 "applicationCategory": "FinanceApplication",
                 "operatingSystem": "Web",
                 "offers": {
                     "@type": "Offer",
                     "price": "0",
                     "priceCurrency": "USD"
                 },
                 "provider": {
                     "@type": "Organization",
                     "name": "EU VAT Info",
                     "url": "<?php echo e(url('/')); ?>"
                 },
                 "about": {
                     "@type": "GovernmentService",
                     "name": "<?php echo e($selectedCountryObject->name); ?> VAT",
                     "serviceType": "Value Added Tax",
                     "areaServed": {
                         "@type": "Country",
                         "name": "<?php echo e($selectedCountryObject->name); ?>"
                     }
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
<?php else: ?>
<?php $__env->startSection('title', 'VAT Calculator - EU-VAT.info'); ?>
<?php $__env->startSection('meta_description',
    'Calculate VAT amount for different countries. Use our VAT
    calculator to easily calculate VAT for transactions in different countries.'); ?>
<?php $__env->startSection('seo'); ?>
    <?php if (isset($component)) { $__componentOriginal84f9df3f620371229981225e7ba608d7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal84f9df3f620371229981225e7ba608d7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.seo-meta','data' => ['title' => 'VAT Calculator - EU Countries | EU VAT Info','description' => 'Calculate VAT for all EU countries. Free online calculator with current rates, historical data, and comparison tools.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('seo-meta'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'VAT Calculator - EU Countries | EU VAT Info','description' => 'Calculate VAT for all EU countries. Free online calculator with current rates, historical data, and comparison tools.']); ?>
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
<?php endif; ?>

<div class="container py-12 mt-12 pb-12">
    <?php if(isset($selectedCountryObject)): ?>
        <?php if (isset($component)) { $__componentOriginal360d002b1b676b6f84d43220f22129e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal360d002b1b676b6f84d43220f22129e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumbs','data' => ['items' => ['VAT Calculator' => '/vat-calculator', $selectedCountryObject->name => '']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['VAT Calculator' => '/vat-calculator', $selectedCountryObject->name => ''])]); ?>
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
    <?php else: ?>
        <?php if (isset($component)) { $__componentOriginal360d002b1b676b6f84d43220f22129e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal360d002b1b676b6f84d43220f22129e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumbs','data' => ['items' => ['VAT Calculator' => '']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['VAT Calculator' => ''])]); ?>
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
    <?php endif; ?>

<div class="mb-6 mt-6  mx-auto">
    <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 tracking-tight mb-6">
        <?php if(isset($selectedCountryObject)): ?>
            <?php echo e($selectedCountryObject->name); ?> <span class="text-blue-600">VAT Calculator</span>
        <?php else: ?>
            European <span class="text-blue-600">VAT Calculator</span>
        <?php endif; ?>
    </h1>
    
    <?php if(isset($selectedCountryObject)): ?>
        <p class="text-lg text-gray-600 leading-relaxed">
            Calculate VAT for transactions in <?php echo e($selectedCountryObject->name); ?> easily. 
            Current standard rate is <span class="font-bold text-gray-900"><?php echo e($selectedCountryObject->standard_rate); ?>%</span>.
        </p>
    <?php else: ?>
        <p class="text-lg text-gray-600 leading-relaxed">
            Quickly calculate VAT amounts for any of the 27 European Union member states. 
            Updated daily with the latest rates.
        </p>
    <?php endif; ?>
</div>

<!-- Main Grid Container -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
    <!-- Calculator Form (Prominent) -->
    <div class="lg:col-span-7 order-1">
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('vat-calculator-form', ['slug' => $selectedCountryObject->slug ?? null]);

$__html = app('livewire')->mount($__name, $__params, 'lw-490223134-3', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    </div>

    <!-- Sidebar / Info -->
    <div class="lg:col-span-5 order-2 space-y-6">
        <?php if(isset($selectedCountryObject)): ?>
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Current VAT Rates</h3>
                <?php if (isset($component)) { $__componentOriginal6d65c1dbe183f940bc2e50d860d220fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6d65c1dbe183f940bc2e50d860d220fc = $attributes; } ?>
<?php $component = App\View\Components\CountryRates::resolve(['country' => $selectedCountryObject] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('country-rates'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\CountryRates::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6d65c1dbe183f940bc2e50d860d220fc)): ?>
<?php $attributes = $__attributesOriginal6d65c1dbe183f940bc2e50d860d220fc; ?>
<?php unset($__attributesOriginal6d65c1dbe183f940bc2e50d860d220fc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6d65c1dbe183f940bc2e50d860d220fc)): ?>
<?php $component = $__componentOriginal6d65c1dbe183f940bc2e50d860d220fc; ?>
<?php unset($__componentOriginal6d65c1dbe183f940bc2e50d860d220fc); ?>
<?php endif; ?>
            </div>
        <?php endif; ?>

        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('vat-rate-history-chart', ['country' => $selectedCountryObject]);

$__html = app('livewire')->mount($__name, $__params, 'lw-490223134-4', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

        <?php if(isset($selectedCountryObject)): ?>
        <div class="bg-blue-50 p-6 rounded-xl border border-blue-100">
            <h4 class="font-bold text-blue-900 mb-2">Need more details?</h4>
            <p class="text-sm text-blue-700 mb-4">
                Learn everything about VAT compliance, registration, and exceptions in <?php echo e($selectedCountryObject->name); ?>.
            </p>
            <a wire:navigate href="<?php echo e(route('country.show', $selectedCountryObject->slug)); ?>" class="text-sm font-bold text-blue-600 hover:text-blue-800 hover:underline">
                View <?php echo e($selectedCountryObject->name); ?> VAT Guide &rarr;
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>

<div class="mt-16 grid grid-cols-1 gap-8">
    <!-- Map Section -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('europe-map', ['activeCountry' => $selectedCountryObject]);

$__html = app('livewire')->mount($__name, $__params, 'lw-490223134-5', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    </div>

    <!-- Saved Searches & Links -->
    <div>
        <?php if (isset($component)) { $__componentOriginal0952f6d981baec1dc26f3a93503017ba = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0952f6d981baec1dc26f3a93503017ba = $attributes; } ?>
<?php $component = App\View\Components\SavedSearches::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('saved-searches'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\SavedSearches::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0952f6d981baec1dc26f3a93503017ba)): ?>
<?php $attributes = $__attributesOriginal0952f6d981baec1dc26f3a93503017ba; ?>
<?php unset($__attributesOriginal0952f6d981baec1dc26f3a93503017ba); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0952f6d981baec1dc26f3a93503017ba)): ?>
<?php $component = $__componentOriginal0952f6d981baec1dc26f3a93503017ba; ?>
<?php unset($__componentOriginal0952f6d981baec1dc26f3a93503017ba); ?>
<?php endif; ?>
    </div>

    <div class="pb-12">
        <?php if (isset($component)) { $__componentOriginal5144fbdfdd33fb88dd2865cc70b85582 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5144fbdfdd33fb88dd2865cc70b85582 = $attributes; } ?>
<?php $component = App\View\Components\CountryCalculatorList::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('country-calculator-list'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\CountryCalculatorList::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5144fbdfdd33fb88dd2865cc70b85582)): ?>
<?php $attributes = $__attributesOriginal5144fbdfdd33fb88dd2865cc70b85582; ?>
<?php unset($__attributesOriginal5144fbdfdd33fb88dd2865cc70b85582); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5144fbdfdd33fb88dd2865cc70b85582)): ?>
<?php $component = $__componentOriginal5144fbdfdd33fb88dd2865cc70b85582; ?>
<?php unset($__componentOriginal5144fbdfdd33fb88dd2865cc70b85582); ?>
<?php endif; ?>
    </div>
</div>
</div><?php /**PATH /home/runner/work/eu-vat.info/eu-vat.info/resources/views/livewire/vat-calculator.blade.php ENDPATH**/ ?>