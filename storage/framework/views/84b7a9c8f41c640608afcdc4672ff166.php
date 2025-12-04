 <div>
     <?php if($saved_searches): ?>
         <?php if(count($saved_searches) > 0): ?>
             <div class="pb-9 pt-9">
                 <div class="flex justify-between items-center mb-6">
                     <h3>Saved Calculations (<?php echo e(count($saved_searches)); ?>) </h3>

                     <div class="">
                         <?php if (isset($component)) { $__componentOriginal602b228a887fab12f0012a3179e5b533 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal602b228a887fab12f0012a3179e5b533 = $attributes; } ?>
<?php $component = Mary\View\Components\Button::resolve(['label' => 'Clear'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'btn-outline','wire:click' => 'clearSearch']); ?>
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
                 </div>
                 <?php if($saved_searches): ?>
                     <div class="grid sm:grid-cols-4 gap-6">
                         <?php $__currentLoopData = $saved_searches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $search): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                             <?php
                                 $saved_country = App\Models\Country::where('slug', $search['selectedCountry1'])->first();
                                 $saved_link = route('vat-calculator', [
                                     'selectedCountry1' => $search['selectedCountry1'],
                                     'amount' => $search['amount'],
                                     'selectedRate' => $search['selectedRate'],
                                     'vat_included' => $search['vat_included'],
                                 ]);
                             ?>
                             <a href="<?php echo e($saved_link); ?>" wire.navigate="<?php echo e($saved_link); ?>">
                                 <div class="card p-6 bg-white shadow-xl">
                                     <?php echo e($saved_country->name); ?>

                                     <div class="text-sm text-green-600">
                                         <?php echo e(Number::currency($search['amount'], 'EUR')); ?>

                                         (<?php echo e($search['selectedRate']); ?>%)
                                         -
                                         <?php echo e($search['vat_included']); ?>

                                     </div>
                                 </div>
                             </a>
                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </div>
                 <?php endif; ?>

             </div>
         <?php else: ?>
             Your saved searches will appear here.
         <?php endif; ?>
     <?php endif; ?>
 </div>
<?php /**PATH /home/runner/work/eu-vat.info/eu-vat.info/resources/views/components/saved-searches.blade.php ENDPATH**/ ?>