<footer class="bg-gray-900 text-gray-400 py-12 mt-12 border-t border-gray-800">
    <div class="mx-auto max-w-7xl px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 mb-8">
            <div class="col-span-1 lg:col-span-2">
                <div class="text-white text-xl font-bold mb-4">{{ __('ui.site_name') }}</div>
                <p class="mb-4 text-sm">
                    {{ __('ui.footer.description') }}
                </p>
                <div class="flex space-x-4">
                    <a href="https://github.com/eimkasp/eu-vat.info" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors" title="{{ __('ui.site_name') }} on GitHub">
                        @svg('feathericon-github', 'w-6 h-6')
                    </a>
                </div>
            </div>
            
            <div>
                <h3 class="text-white font-semibold mb-4">{{ __('ui.footer.vat_tools') }}</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ locale_path('/vat-calculator') }}" wire:navigate class="hover:text-white transition-colors">{{ __('ui.footer.vat_calculator') }}</a></li>
                    <li><a href="{{ locale_path('/vat-map') }}" wire:navigate class="hover:text-white transition-colors">{{ __('ui.footer.interactive_map') }}</a></li>
                    <li><a href="{{ locale_path('/vat-changes') }}" wire:navigate class="hover:text-white transition-colors">{{ __('ui.footer.vat_rate_history') }}</a></li>
                    <li><a href="{{ route('widget.embed') }}" wire:navigate class="hover:text-white transition-colors">{{ __('ui.footer.embed_widget') }}</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-white font-semibold mb-4">{{ __('ui.footer.resources') }}</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ locale_path('/sitemap') }}" wire:navigate class="hover:text-white transition-colors">{{ __('ui.footer.sitemap') }}</a></li>
                    <li><a href="/llms.txt" class="hover:text-white transition-colors">{{ __('ui.footer.llms_data') }}</a></li>
                    <li><a href="/api/llm/vat-rates" class="hover:text-white transition-colors">{{ __('ui.footer.vat_rates_api') }}</a></li>
                    <li><a href="/sitemap.xml" class="hover:text-white transition-colors">{{ __('ui.footer.xml_sitemap') }}</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-white font-semibold mb-4">{{ __('ui.footer.partner_tools') }}</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="https://pdf.businesspress.io/" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors">{{ __('ui.footer.pdf_tools') }}</a></li>
                    <li><a href="https://ec.europa.eu/taxation_customs/vies/" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors">{{ __('ui.footer.eu_vies') }}</a></li>
                    <li><a href="https://europa.eu/youreurope/business/taxation/vat/" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors">{{ __('ui.footer.eu_vat_guide') }}</a></li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center text-sm">
            <div class="mb-4 md:mb-0">
                &copy; {{ date('Y') }} {{ __('ui.site_name') }}. {{ __('ui.all_rights_reserved') }}
            </div>
            <div class="flex space-x-6 items-center">
                <a href="{{ locale_path('/sitemap') }}" wire:navigate class="hover:text-white transition-colors">{{ __('ui.footer.sitemap') }}</a>
                <a href="/llms.txt" class="hover:text-white transition-colors">llms.txt</a>
                <a href="https://pdf.businesspress.io/" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors">PDF Tools</a>
                <span class="text-gray-600">{{ __('ui.data_updated_daily') }}</span>
            </div>
        </div>
    </div>
</footer>
