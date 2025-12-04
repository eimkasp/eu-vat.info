<footer class="bg-gray-900 text-gray-400 py-12 mt-12 border-t border-gray-800">
    <div class="mx-auto max-w-7xl px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            <div class="col-span-1 md:col-span-2">
                <div class="text-white text-xl font-bold mb-4">EU VAT Info</div>
                <p class="mb-4 text-sm">
                    Your trusted source for current VAT rates, calculations, and compliance information across all 27 European Union member states.
                </p>
                <div class="flex space-x-4">
                    <a href="https://github.com/eimkasp/eu-vat.info" target="_blank" class="hover:text-white transition-colors">
                        <?php echo e(svg('feathericon-github', 'w-6 h-6')); ?>
                    </a>
                </div>
            </div>
            
            <div>
                <h3 class="text-white font-semibold mb-4">Tools</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="<?php echo e(route('vat-calculator')); ?>" class="hover:text-white transition-colors">VAT Calculator</a></li>
                    <li><a href="<?php echo e(route('vat-map')); ?>" class="hover:text-white transition-colors">VAT Map</a></li>
                    <li><a href="<?php echo e(route('vat-changes')); ?>" class="hover:text-white transition-colors">Rate Changes</a></li>
                    
                </ul>
            </div>

            <div>
                <h3 class="text-white font-semibold mb-4">Resources</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="<?php echo e(route('widget.embed')); ?>" class="hover:text-white transition-colors">Embed Widget</a></li>
                    <li><a href="/llms.txt" class="hover:text-white transition-colors">API for AI/LLMs</a></li>
                    <li><a href="/sitemap.xml" class="hover:text-white transition-colors">Sitemap</a></li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center text-sm">
            <div class="mb-4 md:mb-0">
                &copy; <?php echo e(date('Y')); ?> EU VAT Info. All rights reserved.
            </div>
            <div class="flex space-x-6">
                <span class="text-gray-600">Data updated daily</span>
            </div>
        </div>
    </div>
</footer>
<?php /**PATH /home/runner/work/eu-vat.info/eu-vat.info/resources/views/components/footer.blade.php ENDPATH**/ ?>