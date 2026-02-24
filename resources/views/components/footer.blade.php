<footer class="bg-gray-900 text-gray-400 py-12 mt-12 border-t border-gray-800">
    <div class="mx-auto max-w-7xl px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 mb-8">
            <div class="col-span-1 lg:col-span-2">
                <div class="text-white text-xl font-bold mb-4">EU VAT Info</div>
                <p class="mb-4 text-sm">
                    Your trusted source for current VAT rates, calculations, and compliance information across all 27 European Union member states. Updated daily with the latest rates.
                </p>
                <div class="flex space-x-4">
                    <a href="https://github.com/eimkasp/eu-vat.info" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors" title="EU VAT Info on GitHub">
                        @svg('feathericon-github', 'w-6 h-6')
                    </a>
                </div>
            </div>
            
            <div>
                <h3 class="text-white font-semibold mb-4">VAT Tools</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('vat-calculator') }}" wire:navigate class="hover:text-white transition-colors">VAT Calculator</a></li>
                    <li><a href="{{ route('vat-map') }}" wire:navigate class="hover:text-white transition-colors">Interactive VAT Map</a></li>
                    <li><a href="{{ route('vat-changes') }}" wire:navigate class="hover:text-white transition-colors">VAT Rate History</a></li>
                    <li><a href="{{ route('widget.embed') }}" wire:navigate class="hover:text-white transition-colors">Embed VAT Widget</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-white font-semibold mb-4">Resources</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('html-sitemap') }}" wire:navigate class="hover:text-white transition-colors">Sitemap</a></li>
                    <li><a href="/llms.txt" class="hover:text-white transition-colors">llms.txt - AI/LLM Data</a></li>
                    <li><a href="/api/llm/vat-rates" class="hover:text-white transition-colors">VAT Rates API (JSON)</a></li>
                    <li><a href="/sitemap.xml" class="hover:text-white transition-colors">XML Sitemap</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-white font-semibold mb-4">Partner Tools</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="https://pdf.businesspress.io/" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors">PDF Tools - BusinessPress</a></li>
                    <li><a href="https://ec.europa.eu/taxation_customs/vies/" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors">EU VIES Validation</a></li>
                    <li><a href="https://europa.eu/youreurope/business/taxation/vat/" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors">EU VAT Guide</a></li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center text-sm">
            <div class="mb-4 md:mb-0">
                &copy; {{ date('Y') }} EU VAT Info. All rights reserved.
            </div>
            <div class="flex space-x-6 items-center">
                <a href="{{ route('html-sitemap') }}" wire:navigate class="hover:text-white transition-colors">Sitemap</a>
                <a href="/llms.txt" class="hover:text-white transition-colors">llms.txt</a>
                <a href="https://pdf.businesspress.io/" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors">PDF Tools</a>
                <span class="text-gray-600">Data updated daily</span>
            </div>
        </div>
    </div>
</footer>
