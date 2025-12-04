<div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 text-white flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-xl font-semibold flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                VAT Calculator
            </h2>
            <p class="text-blue-100 text-sm !mb-0 opacity-90">Calculate VAT rates instantly</p>
        </div>

        <div class="w-full sm:w-auto">
            <div class="relative">
                <select wire:model.live="selectedCountry1" wire:change="calculate" class="appearance-none bg-blue-800/30 border border-blue-400/50 text-white rounded-lg pl-4 pr-10 py-2 text-sm focus:ring-2 focus:ring-white/50 focus:border-white transition-all cursor-pointer hover:bg-blue-800/50 w-full sm:w-64">
                    <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($country->slug); ?>" class="text-gray-900">
                            <?php echo e($country->name_with_flag); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-blue-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="p-6">
        <?php if (isset($component)) { $__componentOriginal6bfd0631c6b8a47111403266db046f63 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6bfd0631c6b8a47111403266db046f63 = $attributes; } ?>
<?php $component = Mary\View\Components\Form::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Form::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:submit' => 'calculate','class' => 'space-y-6']); ?>
            
            <div class="space-y-2">
                <?php if (isset($component)) { $__componentOriginalf51438a7488970badd535e5f203e0c1b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf51438a7488970badd535e5f203e0c1b = $attributes; } ?>
<?php $component = Mary\View\Components\Input::resolve(['label' => 'Amount','suffix' => 'EUR (€)','money' => true] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:change' => 'calculate','wire:model.lazy' => 'amount','type' => 'text','class' => 'text-lg font-medium']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf51438a7488970badd535e5f203e0c1b)): ?>
<?php $attributes = $__attributesOriginalf51438a7488970badd535e5f203e0c1b; ?>
<?php unset($__attributesOriginalf51438a7488970badd535e5f203e0c1b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf51438a7488970badd535e5f203e0c1b)): ?>
<?php $component = $__componentOriginalf51438a7488970badd535e5f203e0c1b; ?>
<?php unset($__componentOriginalf51438a7488970badd535e5f203e0c1b); ?>
<?php endif; ?>
            </div>

            <?php if(isset($selectedCountryObject)): ?>
                
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 space-y-3">
                    <label class="text-sm font-medium text-gray-700 block">VAT Rate</label>
                    <div class="grid grid-cols-1 gap-2">
                        <?php $__currentLoopData = $rates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="relative flex items-center p-3 rounded-lg border cursor-pointer hover:bg-white transition-colors <?php echo e($selectedRate == $rate['value'] ? 'bg-white border-blue-500 ring-1 ring-blue-500' : 'border-gray-200'); ?>">
                                <input type="radio" name="rate" wire:model.live="selectedRate" value="<?php echo e($rate['value']); ?>" wire:change="calculate" class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="ml-3 flex flex-col">
                                    <span class="block text-sm font-medium text-gray-900"><?php echo e($rate['name']); ?></span>
                                </span>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Calculation Mode</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <label class="cursor-pointer relative group">
                            <input type="radio" name="vat_included" value="include" class="peer sr-only" wire:model="vat_included" wire:change="calculate">
                            <div class="p-4 rounded-xl border-2 transition-all hover:border-blue-200 h-full flex flex-col justify-center <?php echo e($vat_included === 'include' ? 'border-blue-600 bg-blue-50' : 'border-gray-100 bg-gray-50'); ?>">
                                <div class="flex items-center gap-2 mb-1">
                                    <div class="w-4 h-4 rounded-full border flex items-center justify-center <?php echo e($vat_included === 'include' ? 'border-blue-600 bg-blue-600' : 'border-gray-400'); ?>">
                                        <div class="w-1.5 h-1.5 rounded-full bg-white <?php echo e($vat_included === 'include' ? 'opacity-100' : 'opacity-0'); ?>"></div>
                                    </div>
                                    <span class="font-bold <?php echo e($vat_included === 'include' ? 'text-blue-900' : 'text-gray-900'); ?>">Price includes VAT</span>
                                </div>
                                <span class="text-xs text-gray-500 ml-6">Extract VAT from total amount</span>
                            </div>
                        </label>

                        <label class="cursor-pointer relative group">
                            <input type="radio" name="vat_included" value="exclude" class="peer sr-only" wire:model="vat_included" wire:change="calculate">
                            <div class="p-4 rounded-xl border-2 transition-all hover:border-blue-200 h-full flex flex-col justify-center <?php echo e($vat_included === 'exclude' ? 'border-blue-600 bg-blue-50' : 'border-gray-100 bg-gray-50'); ?>">
                                <div class="flex items-center gap-2 mb-1">
                                    <div class="w-4 h-4 rounded-full border flex items-center justify-center <?php echo e($vat_included === 'exclude' ? 'border-blue-600 bg-blue-600' : 'border-gray-400'); ?>">
                                        <div class="w-1.5 h-1.5 rounded-full bg-white <?php echo e($vat_included === 'exclude' ? 'opacity-100' : 'opacity-0'); ?>"></div>
                                    </div>
                                    <span class="font-bold <?php echo e($vat_included === 'exclude' ? 'text-blue-900' : 'text-gray-900'); ?>">Price excludes VAT</span>
                                </div>
                                <span class="text-xs text-gray-500 ml-6">Add VAT to net amount</span>
                            </div>
                        </label>
                    </div>
                </div>
            <?php endif; ?>

            <?php if($error_message): ?>
                <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <?php echo e($error_message); ?>

                </div>
            <?php endif; ?>

            
            <?php if($total && !$error_message): ?>
                <div class="bg-white rounded-xl shadow-lg mt-8 overflow-hidden border-l-4 border-blue-600"
                     wire:transition.scale.origin.top>
                    <div class="p-6" wire:loading.class="opacity-50" wire:target="calculate">
                        <div class="grid grid-cols-2 gap-8 mb-6">
                            <div>
                                <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Net Amount</div>
                                <div class="text-xl font-medium text-gray-900">
                                    <?php echo e(is_numeric($amount) ? Number::currency((float)($vat_included == 'include' ? $total - $vat_amount : $amount), 'EUR') : '0.00 €'); ?>

                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">VAT (<?php echo e($selectedRate); ?>%)</div>
                                <div class="text-xl font-medium text-blue-600">
                                    <?php echo e(is_numeric($vat_amount) ? Number::currency((float)$vat_amount, 'EUR') : '0.00 €'); ?>

                                </div>
                            </div>
                        </div>
                        
                        <div class="pt-6 border-t border-gray-100 flex justify-between items-center bg-gray-50 -mx-6 -mb-6 px-6 py-4">
                            <span class="font-medium text-gray-500">Total to Pay</span>
                            <span class="text-3xl font-bold text-gray-900 tracking-tight">
                                <?php echo e(is_numeric($total) ? Number::currency((float)($vat_included == 'include' ? $amount : $total), 'EUR') : '0.00 €'); ?>

                            </span>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

             <?php $__env->slot('actions', null, []); ?> 
                <div class="flex gap-3 w-full">
                    <?php if (isset($component)) { $__componentOriginal602b228a887fab12f0012a3179e5b533 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal602b228a887fab12f0012a3179e5b533 = $attributes; } ?>
<?php $component = Mary\View\Components\Button::resolve(['label' => 'Save','icon' => 'o-bookmark','spinner' => 'saveSearch'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'flex-1 btn-outline','wire:click' => 'saveSearch']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $attributes = $__attributesOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__attributesOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $component = $__componentOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__componentOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal602b228a887fab12f0012a3179e5b533 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal602b228a887fab12f0012a3179e5b533 = $attributes; } ?>
<?php $component = Mary\View\Components\Button::resolve(['label' => 'Calculate','icon' => 'o-calculator','spinner' => 'calculate'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'flex-1 btn-primary bg-blue-600 hover:bg-blue-700 text-white','type' => 'submit']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $attributes = $__attributesOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__attributesOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $component = $__componentOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__componentOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
                </div>
             <?php $__env->endSlot(); ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6bfd0631c6b8a47111403266db046f63)): ?>
<?php $attributes = $__attributesOriginal6bfd0631c6b8a47111403266db046f63; ?>
<?php unset($__attributesOriginal6bfd0631c6b8a47111403266db046f63); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6bfd0631c6b8a47111403266db046f63)): ?>
<?php $component = $__componentOriginal6bfd0631c6b8a47111403266db046f63; ?>
<?php unset($__componentOriginal6bfd0631c6b8a47111403266db046f63); ?>
<?php endif; ?>
    </div>
</div><?php /**PATH /home/runner/work/eu-vat.info/eu-vat.info/resources/views/livewire/vat-calculator-form.blade.php ENDPATH**/ ?>