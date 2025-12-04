<div class="container">
    <?php $__env->startSection('seo'); ?>
        <?php if (isset($component)) { $__componentOriginal84f9df3f620371229981225e7ba608d7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal84f9df3f620371229981225e7ba608d7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.seo-meta','data' => ['title' => 'VAT Rates in ' . $country->name . ' - EU VAT Info','description' => 'The standard VAT rate in ' . $country->name . ' is ' . $country->standard_rate . '%. Learn about VAT rates, exceptions, and compliance in ' . $country->name . '.','image' => route('og-image.country', $country->slug)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('seo-meta'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('VAT Rates in ' . $country->name . ' - EU VAT Info'),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('The standard VAT rate in ' . $country->name . ' is ' . $country->standard_rate . '%. Learn about VAT rates, exceptions, and compliance in ' . $country->name . '.'),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('og-image.country', $country->slug))]); ?>
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
        <div class="">
            <div class="relative w-full">
                <div class="grid sm:grid-cols-12 gap-9">
                    <div class="sm:col-span-12">
                        
                    </div>
                    <div class="sm:col-span-4 sm:sticky top-[-1px] sticky-element" style="align-self: flex-start">
                        <a href="/" class="mb-3 block flex items-center gap-3 hover:text-blue-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                            </svg>
                            Back to all countries
                        </a>
                        <?php if (isset($component)) { $__componentOriginal019c0e6b0f833b24d1cabd80837af094 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal019c0e6b0f833b24d1cabd80837af094 = $attributes; } ?>
<?php $component = App\View\Components\CountryStats::resolve(['country' => $country] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('country-stats'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\CountryStats::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal019c0e6b0f833b24d1cabd80837af094)): ?>
<?php $attributes = $__attributesOriginal019c0e6b0f833b24d1cabd80837af094; ?>
<?php unset($__attributesOriginal019c0e6b0f833b24d1cabd80837af094); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal019c0e6b0f833b24d1cabd80837af094)): ?>
<?php $component = $__componentOriginal019c0e6b0f833b24d1cabd80837af094; ?>
<?php unset($__componentOriginal019c0e6b0f833b24d1cabd80837af094); ?>
<?php endif; ?>
                        <div class="mt-9 space-y-3 sm:mb-12 border-t pt-3">
                            <h4>VAT Tools</h4>

                            <div>
                                <a class="text-blue-600 hover:underline" wire:navigate="/vat-calculator/<?php echo e($country->slug); ?>"
                                    href="/vat-calculator/<?php echo e($country->slug); ?>">VAT Calculator for <?php echo e($country->name); ?>


                                </a>
                            </div>

                            <div>
                                <a class="text-blue-600 hover:underline" wire:navigate="/vat-calculator/<?php echo e($country->slug); ?>"
                                    href="/embed/<?php echo e($country->slug); ?>">Embed <?php echo e($country->name); ?> VAT Widget
                                    
                                    <span class="badge badge-info ml-2">New</span>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Sidebar Banners -->
                        <?php if (isset($component)) { $__componentOriginale783cf2f069f755e6c9cc2080fac9748 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale783cf2f069f755e6c9cc2080fac9748 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.banner-display','data' => ['position' => 'country_sidebar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('banner-display'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['position' => 'country_sidebar']); ?>
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
                    </div>

                    <div class="sm:col-span-8 pb-12">
                        <?php if (isset($component)) { $__componentOriginal360d002b1b676b6f84d43220f22129e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal360d002b1b676b6f84d43220f22129e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumbs','data' => ['items' => [$country->name => '']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([$country->name => ''])]); ?>
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
                        
                        <div class="space-y-3">
                            <h1 class="text-2xl lg:text-3xl font-bold">
                                VAT rates for goods and services in <?php echo e($country->name); ?>

                            </h1>
                            <p class="text-gray-500 dark:text-gray-400">

                            </p>
                        </div>
                        <div class="mb-6">
                            <?php if (isset($component)) { $__componentOriginal6d65c1dbe183f940bc2e50d860d220fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6d65c1dbe183f940bc2e50d860d220fc = $attributes; } ?>
<?php $component = App\View\Components\CountryRates::resolve(['country' => $country] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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

                        

                        <div class="country-content max-w-3xl mx-auto">
                            <article class="prose prose-blue prose-lg max-w-none">
                                <h2 class="text-3xl font-bold text-gray-900 mb-6"><?php echo e($country->name); ?> VAT Guide</h2>

                                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-10">
                                    <h3 class="text-xl font-bold text-gray-900 mb-4">Introduction</h3>
                                    <p class="text-gray-600 leading-relaxed mb-0">
                                        <?php echo e($country->name); ?>, as a member of the European Union, maintains its own unique VAT system. 
                                        The standard VAT rate is <span class="font-bold text-blue-600"><?php echo e($country->standard_rate); ?>%</span>, 
                                        which applies to most goods and services. 
                                        Using our <a href="<?php echo e(route('vat-calculator.country', $country->slug)); ?>" class="text-blue-600 hover:underline font-medium">VAT Calculator</a>, 
                                        you can easily calculate the exact VAT amount for any transaction.
                                    </p>
                                </div>

                                <div class="space-y-10">
                                    <section>
                                        <h3 class="text-2xl font-bold text-gray-900 mb-4">VAT Rate Structure</h3>
                                        <p class="text-gray-600 mb-4"><?php echo e($country->name); ?> applies different rates depending on the product or service:</p>
                                        
                                        <div class="grid sm:grid-cols-2 gap-4 not-prose">
                                            <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                                                <div class="text-sm text-blue-600 font-semibold uppercase tracking-wide mb-1">Standard Rate</div>
                                                <div class="text-3xl font-bold text-gray-900"><?php echo e($country->standard_rate); ?>%</div>
                                                <div class="text-sm text-gray-500 mt-1">Most goods & services</div>
                                            </div>
                                            <?php if($country->reduced_rate): ?>
                                            <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                                                <div class="text-sm text-green-600 font-semibold uppercase tracking-wide mb-1">Reduced Rate</div>
                                                <div class="text-3xl font-bold text-gray-900"><?php echo e($country->reduced_rate); ?>%</div>
                                                <div class="text-sm text-gray-500 mt-1">Essentials (Food, Books, etc.)</div>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </section>

                                    <section>
                                        <h3 class="text-2xl font-bold text-gray-900 mb-4">VAT Registration & Compliance</h3>
                                        <p class="text-gray-600 leading-relaxed">
                                            Businesses operating in <?php echo e($country->name); ?> must register for VAT if their annual turnover exceeds the national threshold. 
                                            Foreign companies trading in <?php echo e($country->name); ?> may need to register immediately without a threshold.
                                        </p>
                                    </section>

                                    <section>
                                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Tools & Resources</h3>
                                        <p class="text-gray-600 leading-relaxed">
                                            Use our specialized tools to manage your VAT obligations:
                                            <ul class="list-disc pl-5 space-y-2 mt-2">
                                                <li><a href="<?php echo e(route('vat-calculator.country', $country->slug)); ?>" class="text-blue-600 hover:underline">Calculate VAT for <?php echo e($country->name); ?></a></li>
                                                <li>Check valid VAT numbers via VIES (Coming Soon)</li>
                                                <li>View historical rate changes</li>
                                            </ul>
                                        </p>
                                    </section>
                                </div>
                            </article>
                        </div>

                        <!-- FAQ Section -->
                        <div class="mt-12 mb-8">
                            <h2 class="text-2xl font-bold mb-6">How to Calculate VAT in <?php echo e($country->name); ?></h2>
                            
                            <div class="space-y-6">
                                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                                    <h3 class="text-lg font-bold mb-3 text-gray-900">Adding VAT to a Net Price</h3>
                                    <p class="text-gray-600 mb-4">To calculate the gross amount from a net price (excluding VAT), use the following formula:</p>
                                    <div class="bg-gray-50 p-4 rounded-lg font-mono text-sm text-gray-800 mb-4 border border-gray-200">
                                        Gross Amount = Net Price × (1 + VAT Rate / 100)
                                    </div>
                                    <div class="text-sm text-gray-600">
                                        <strong>Example:</strong> Calculating <?php echo e($country->standard_rate); ?>% VAT on €100 net:<br>
                                        €100 × (1 + <?php echo e($country->standard_rate / 100); ?>) = €100 × <?php echo e(1 + $country->standard_rate / 100); ?> = <strong>€<?php echo e(100 * (1 + $country->standard_rate / 100)); ?></strong>
                                    </div>
                                </div>

                                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                                    <h3 class="text-lg font-bold mb-3 text-gray-900">Removing VAT from a Gross Price</h3>
                                    <p class="text-gray-600 mb-4">To calculate the net price from a gross amount (including VAT), use this formula:</p>
                                    <div class="bg-gray-50 p-4 rounded-lg font-mono text-sm text-gray-800 mb-4 border border-gray-200">
                                        Net Price = Gross Amount ÷ (1 + VAT Rate / 100)
                                    </div>
                                    <div class="text-sm text-gray-600">
                                        <strong>Example:</strong> Extracting <?php echo e($country->standard_rate); ?>% VAT from €100 gross:<br>
                                        €100 ÷ (1 + <?php echo e($country->standard_rate / 100); ?>) = €100 ÷ <?php echo e(1 + $country->standard_rate / 100); ?> = <strong>€<?php echo e(number_format(100 / (1 + $country->standard_rate / 100), 2)); ?></strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <h3 class="text-xl font-medium">
                                <?php echo e($country->name); ?> VAT Exceptions
                            </h3>
                            <ul>
                                <li>
                                    Coming Soon
                                </li>
                            </ul>
                        </div>

                        <!-- Country Details -->
                        <div class="mt-8 p-6 bg-gray-50 rounded-xl border border-gray-200">
                            <h3 class="text-lg font-bold mb-4 text-gray-900">Quick Facts about <?php echo e($country->name); ?></h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                <div>
                                    <div class="text-xs text-gray-500 uppercase tracking-wider mb-1">ISO Code</div>
                                    <div class="font-mono font-medium text-gray-900"><?php echo e($country->iso_code); ?></div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 uppercase tracking-wider mb-1">Currency</div>
                                    <div class="font-medium text-gray-900"><?php echo e($country->currency_code ?? 'EUR'); ?></div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 uppercase tracking-wider mb-1">Standard Rate</div>
                                    <div class="font-bold text-blue-600"><?php echo e($country->standard_rate); ?>%</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 uppercase tracking-wider mb-1">EU Member</div>
                                    <div class="font-medium text-green-600 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Yes
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="hidden mt-9">
            <h3 class="text-xl font-medium mb-3">Related countries</h3>
            <?php if (isset($component)) { $__componentOriginal67e1b599ade1f7aa7f32ce7c19cb6806 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal67e1b599ade1f7aa7f32ce7c19cb6806 = $attributes; } ?>
<?php $component = App\View\Components\RelatedCountries::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('related-countries'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\RelatedCountries::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['country' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($country)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal67e1b599ade1f7aa7f32ce7c19cb6806)): ?>
<?php $attributes = $__attributesOriginal67e1b599ade1f7aa7f32ce7c19cb6806; ?>
<?php unset($__attributesOriginal67e1b599ade1f7aa7f32ce7c19cb6806); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal67e1b599ade1f7aa7f32ce7c19cb6806)): ?>
<?php $component = $__componentOriginal67e1b599ade1f7aa7f32ce7c19cb6806; ?>
<?php unset($__componentOriginal67e1b599ade1f7aa7f32ce7c19cb6806); ?>
<?php endif; ?>

        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const el = document.querySelector(".sticky-element")
                const observer = new IntersectionObserver(
                    ([e]) => e.target.classList.toggle("is-pinned", e.intersectionRatio < 1), {
                        threshold: [1]
                    }
                );

                observer.observe(el);


                el.addEventListener('click', function() {
                    el.classList.toggle('is-pinned')
                });
            });
        </script>
    </div><?php /**PATH /home/runner/work/eu-vat.info/eu-vat.info/resources/views/livewire/country.blade.php ENDPATH**/ ?>