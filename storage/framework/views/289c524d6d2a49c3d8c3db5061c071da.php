 <?php if(isset($selectedCountry->name)): ?>
<?php $__env->startSection('title', 'Embed VAT Calculator for '. $selectedCountry->name . ' to your website - EU VAT Info'); ?>

<?php else: ?>
<?php $__env->startSection('title', 'Embed VAT Calculator to your website - EU VAT Info'); ?>

<?php endif; ?>
<?php $__env->startSection('meta_description', 'Embed this VAT Calculator widget on your website to show the current VAT rates for all EU
    countries. Customization options available.'); ?>
<?php $__env->startSection('content'); ?>
    <div class="container mx-auto !py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-9">
            <div>
                <h1 class="text-4xl font-bold mb-4">Embed EU VAT Widget
                    <?php if(isset($selectedCountry->name)): ?>
                        for <?php echo e($selectedCountry->name); ?>

                    <?php endif; ?>
                </h1>
                <p class="mb-4">Embed this widget on your website to show the current VAT rates for all EU countries.</p>
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold mb-4">Embed code</h2>
                    <pre id="embed-code" class="bg-gray-100 p-4 rounded-lg w-full break-all whitespace-pre-wrap">&lt;iframe src="<?php echo e(route('widget.iframe')); ?><?php if(isset($selectedCountry->slug)): ?>
/<?php echo e($selectedCountry->slug); ?>

<?php endif; ?>" style="border:none;outline: none;background: transparent;box-shadow: none;" width="100%" height="400px" frameborder="0"&gt;&lt;/iframe&gt;
        </pre>
                    <div class="flex items-center justify-between mt-6">
                        <div class="btn btn-primary plausible-event-name=CopyCode" x-data="{}"
                            @click="navigator.clipboard.writeText(document.getElementById('embed-code').innerText)">Copy
                            code
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                        <div>Forever free!</div>
                    </div>
                </div>

                
                <div class="mt-6 bg-white p-4 rounded-lg shadow-md hidden">
                    <h2 class="text-xl font-bold mb-4">Customize:</h2>
                    <div class="mb-3">
                        <?php if (isset($component)) { $__componentOriginald64144c2287634503c73cd4803d6e578 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald64144c2287634503c73cd4803d6e578 = $attributes; } ?>
<?php $component = Mary\View\Components\Select::resolve(['label' => 'Default Country','optionValue' => 'slug','optionLabel' => 'name','placeholder' => 'Select a country'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Select::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:change' => 'calculate']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald64144c2287634503c73cd4803d6e578)): ?>
<?php $attributes = $__attributesOriginald64144c2287634503c73cd4803d6e578; ?>
<?php unset($__attributesOriginald64144c2287634503c73cd4803d6e578); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald64144c2287634503c73cd4803d6e578)): ?>
<?php $component = $__componentOriginald64144c2287634503c73cd4803d6e578; ?>
<?php unset($__componentOriginald64144c2287634503c73cd4803d6e578); ?>
<?php endif; ?>
                    </div>

                    <div class="">
                        <?php if (isset($component)) { $__componentOriginald64144c2287634503c73cd4803d6e578 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald64144c2287634503c73cd4803d6e578 = $attributes; } ?>
<?php $component = Mary\View\Components\Select::resolve(['label' => 'Style','optionValue' => 'slug','optionLabel' => 'name','placeholder' => 'Simple or Advanced'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Select::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:change' => 'calculate']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald64144c2287634503c73cd4803d6e578)): ?>
<?php $attributes = $__attributesOriginald64144c2287634503c73cd4803d6e578; ?>
<?php unset($__attributesOriginald64144c2287634503c73cd4803d6e578); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald64144c2287634503c73cd4803d6e578)): ?>
<?php $component = $__componentOriginald64144c2287634503c73cd4803d6e578; ?>
<?php unset($__componentOriginald64144c2287634503c73cd4803d6e578); ?>
<?php endif; ?>
                    </div>

                    <p class="mb-4 mt-6">You can customize the widget by adding query parameters to the URL.</p>

                    <div class="flex items center justify-between mt-6">
                        <div class="btn btn-info">Save settings
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold mb-4">Widget Preview</h2>
                    <?php if(isset($selectedCountry->slug)): ?>
                        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('vat-calculator-form', ['slug' => $selectedCountry->slug]);

$__html = app('livewire')->mount($__name, $__params, 'lw-1255428670-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                    <?php else: ?>
                        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('vat-calculator-form', ['slug' => 'united-kingdom-gb']);

$__html = app('livewire')->mount($__name, $__params, 'lw-1255428670-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                    <?php endif; ?>
                    <div class="mt-3 text-right">
                        Powered by <a href="https://eu-vat.info" target="_blank" class="text-blue-500">EU-VAT.info</a>
                    </div>
                </div>
            </div>
            <div class="sm:col-span-2 mt-9">
                <?php if (isset($component)) { $__componentOriginal5144fbdfdd33fb88dd2865cc70b85582 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5144fbdfdd33fb88dd2865cc70b85582 = $attributes; } ?>
<?php $component = App\View\Components\CountryCalculatorList::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('country-calculator-list'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\CountryCalculatorList::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                 <?php echo $__env->renderComponent(); ?>
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
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('components.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/runner/work/eu-vat.info/eu-vat.info/resources/views/widget/embed.blade.php ENDPATH**/ ?>