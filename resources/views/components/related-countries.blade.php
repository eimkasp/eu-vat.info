<ul role="list" class="flex overflow-x-scroll  gap-x-6 gap-y-8 py-6 lg:grid-cols-3 xl:gap-x-8">
    @foreach ($relatedCountries as $singleCountry)
        <li class="min-w-[300px] overflow-hidden rounded-xl border border-gray-200">
            <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-6">
                <img src="https://tailwindui.com/img/logos/48x48/tuple.svg" alt="Tuple"
                    class="h-12 w-12 flex-none rounded-lg bg-white object-cover ring-1 ring-gray-900/10">
                <div class="text-sm font-medium leading-6 text-gray-900">Tuple</div>
                <div class="relative ml-auto">
                    <button type="button" class="-m-2.5 block p-2.5 text-gray-400 hover:text-gray-500"
                        id="options-menu-0-button" aria-expanded="false" aria-haspopup="true">
                        <span class="sr-only">Open options</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path
                                d="M3 10a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM8.5 10a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM15.5 8.5a1.5 1.5 0 100 3 1.5 1.5 0 000-3z" />
                        </svg>
                    </button>


                </div>
            </div>
            <dl class="-my-3 divide-y divide-gray-100 px-6 py-4 text-sm leading-6">
                <div class="flex justify-between gap-x-4 py-3">
                    <dt class="text-gray-500">Last invoice</dt>
                    <dd class="text-gray-700"><time datetime="2022-12-13">December 13, 2022</time></dd>
                </div>
                <div class="flex justify-between gap-x-4 py-3">
                    <dt class="text-gray-500">Amount</dt>
                    <dd class="flex items-start gap-x-2">
                        <div class="font-medium text-gray-900">$2,000.00</div>
                        <div
                            class="rounded-md py-1 px-2 text-xs font-medium ring-1 ring-inset text-red-700 bg-red-50 ring-red-600/10">
                            Overdue</div>
                    </dd>
                </div>
            </dl>
        </li>
    @endforeach
</ul>
