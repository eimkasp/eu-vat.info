<div>
<?php if(count($recentCountries) > 0): ?>
<div class="bg-white rounded-lg shadow-lg p-6 mb-6">
    <h2 class="text-xl font-bold mb-4">Recently Viewed Countries</h2>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
        <?php $__currentLoopData = $recentCountries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('country.show', $country->slug)); ?>" 
           class="flex flex-col items-center p-3 rounded-lg hover:bg-gray-50 transition-colors">
            <img src="https://flagcdn.com/h40/<?php echo e(strtolower($country->iso_code)); ?>.jpg" 
                 alt="<?php echo e($country->name); ?> flag" 
                 class="w-10 h-6 object-cover rounded shadow-sm mb-2">
            <span class="text-sm text-center font-medium"><?php echo e($country->name); ?></span>
            <span class="text-xs text-gray-500"><?php echo e($country->standard_rate); ?>%</span>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php endif; ?>
</div><?php /**PATH /home/runner/work/eu-vat.info/eu-vat.info/resources/views/livewire/recent-countries.blade.php ENDPATH**/ ?>